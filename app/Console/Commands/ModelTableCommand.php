<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ModelTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model-table {model} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para crear el modelo, pero definiendo el nombre de la tabla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $name = $this->argument('model');
            $tableName = $this->argument('table');

            // Generar el modelo usando el comando artisan make:model
            $this->call('make:model', ['name' => $name]);

            // Obtener columnas de la tabla correspondiente
            $columns = Schema::getColumnListing($tableName);

            // Excluir columnas 'id', 'created_at', y 'updated_at'
            $fillable = array_filter($columns, function ($column) {
                return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
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

            // Insertar scopes personalizados
            $modelContent = str_replace(
                "}\n",
                "\n    public function scopeListado(\$query)\n    {\n        // Define the listado scope\n    }\n\n    public function scopeSearch(\$query, \$term)\n    {\n        // Define the search scope\n    }\n}\n",
                $modelContent
            );

            // Escribir el contenido modificado de nuevo al archivo
            file_put_contents($modelPath, $modelContent);

            $this->info("Model $name created with custom configurations.");
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
