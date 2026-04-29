<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReportExceptionToGithub implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 10;

    protected array $data;

    public function __construct(Throwable $e)
    {
        try {
            $message = $e->getMessage();
            // Sanitizar mensaje para evitar exponer datos sensibles
            $message = preg_replace('/(password|token)=\S+/i', '$1=***', $message);

            $this->data = [
                'class'   => get_class($e),
                'message' => $message,
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
                'url'     => request()?->fullUrl(),
                'user_name' => optional(auth()->user())->full_name,
                'user_id' => optional(auth()->user())->id,
            ];
        } catch (\Throwable $th) {
            //Mostrar en consola de queue:work si falla la preparación de datos, pero no detener el proceso
            \Log::info("Failed to prepare exception data for GitHub report: {$th->getMessage()}");
            $this->data = [
                'class' => get_class($e),
                'message' => 'Failed to prepare exception data',
                'file' => '',
                'line' => '',
                'trace' => '',
                'url' => '',
                'user_name' => null,
            ];
        }
    }

    public function handle(): void
    {
        try {
            $fingerprint = md5($this->data['class'] . '|' . $this->data['message'] . '|' . $this->data['file'] . '|' . $this->data['line']);

            if (Cache::has($fingerprint)) {
                \Log::info('Fingerprint found in cache, skipping GitHub report.');
                return;
            }

            Cache::put($fingerprint, true, now()->addMinutes(10));

            $repo  = config('services.github.repo');
            $token = config('services.github.token');

            if (!$repo || !$token) {
                \Log::info("GitHub repo or token not configured. Skipping exception report.");
                return;
            }
            [$owner, $repoName] = explode('/', $repo);

            //Tipo de label segun app_env
            $envLabel = match (config('app.env')) {
                'production' => ['production'],
                'staging' => ['staging'],
                'qa' => ['qa'],
                'local' => ['local'],
                default => ['local'],
            };

            $response = Http::withToken($token)
                ->acceptJson()
                ->post("https://api.github.com/repos/{$owner}/{$repoName}/issues", [
                    'title' => "ISSUE: {$this->data['message']}",
                    'body'  => $this->formatBody(),
                    'labels' => array_merge(['bug'], $envLabel),
                ]);

            if (!$response->successful()) {
                \Log::info("Failed to report exception to GitHub. Status: " . $response->status());
            }
        } catch (\Throwable $th) {
            \Log::info("Failed to report exception to GitHub: {$th->getMessage()}");
        }
    }

    protected function formatBody(): string
    {
        return "\n**Mensaje**: {$this->data['message']}\n\n**Archivo**: {$this->data['file']}:{$this->data['line']}\n\n**URL**: {$this->data['url']}\n\n**Usuario**: {$this->data['user_name']}\n\n**Stack trace**:\n{$this->data['trace']}\n";
    }
}
