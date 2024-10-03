<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Schema;

class ModelTableResourceControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-table-more {model} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para crear el modelo, pero definiendo el nombre de la tabla: php artisan make:model-table-more Modelo tablas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->argument('model');
            $tableName = $this->argument('table');

            // Generar el modelo usando el comando artisan make:model
            $this->call('make:model', [
                'name' => $name,
                '--controller' => true,
                '--resource' => true
            ]);

            // Crear el FormRequest
            //$this->call('make:request', ['name' => "{$name}Request"]);

            // Obtener columnas de la tabla correspondiente
            $columns = Schema::getColumnListing($tableName);

            // Excluir columnas 'id', 'created_at', y 'updated_at'
            $fillable = array_filter($columns, function ($column) {
                return !in_array($column, ['id', 'created_at', 'updated_at']);
            });

            $fillableArray = "['" . implode("', '", $fillable) . "']";

            // Ruta al archivo del modelo
            $modelPath = app_path("Models/{$name}.php");

            // Leer el contenido del modelo generado
            $modelContent = file_get_contents($modelPath);

            // Insertar $table, $fillable, y SoftDeletes en el modelo
            $modelContent = str_replace(
                "use HasFactory;",
                "use HasFactory, SoftDeletes;\n\n    protected \$table = '$tableName';\n\n    protected \$fillable = $fillableArray;",
                $modelContent
            );

            // Escribir el contenido modificado de nuevo al archivo
            file_put_contents($modelPath, $modelContent);

            ///Crear ModeloResources.php
            $resourceName = "{$name}Resource"; // Nombre del recurso que vas a crear
            $filePathResources = app_path("Http/Resources/{$resourceName}.php"); // Ruta del archivo
            // Crear el directorio si no existe
            if (!File::exists(app_path('Http/Resources'))) {
                File::makeDirectory(app_path('Http/Resources'), 0755, true);
            }
            // Contenido del archivo Resource
            $fileContent = <<<PHP
            <?php
            
            namespace App\Http\Resources;
            
            use Illuminate\Http\Resources\Json\JsonResource;
            
            /**
             * Class {$resourceName}
             */
            class {$resourceName} extends JsonResource
            {
                /**
                 * Transform the resource into an array.
                 *
                 * @param  \Illuminate\Http\Request  \$request
                 */
                public function toArray(\$request): array
                {
                    \$data = \$this->resource->toArray();
                    return \$data;
                }
            }
            
            PHP;

            // Guardar el archivo
            if (!File::exists($filePathResources)) {
                File::put($filePathResources, $fileContent);
                $this->info("Resource {$resourceName} creado exitosamente en app/Http/Resources.");
            } else {
                $this->error("El resource {$resourceName} ya existe.");
            }

            $this->info("Model $name created with custom configurations.");
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
