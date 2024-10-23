<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Str;

class CustomModelCommand extends Command
{
    /**
     * The name and signature of the console command. php artisan make:model-custom Modelo Carpeta
     *
     * @var string
     */
    protected $signature = 'make:model-custom {model} {folder?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para crear modelos con nombre de tabla fillable, softdeleting y busqueda en tabla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        #Comando en consola: php artisan make:model-custom NombreModelo NombreCarpeta
        #Si el modelo va a estar en Models es: php artisan make:model-custom NombreModelo
        #Si va a esta en subcarpeta Models/Pages es: php artisan make:model-custom NombreModelo Pages
        #La tabla debe existir y debe ser el plural en ingles del modelo ejem: Page (modelo), pages (tabla) 
        try {
            $name = $this->argument('model');
            $folder = $this->argument('folder');

            //nombre con carpeta
            $nameFolder = $folder ? $folder . '/' . $name : $name;

            //Nombre tabla se convierte en plural y a snake case
            $tableName = Str::snake(Str::pluralStudly($name));

            // Generar el modelo usando el comando artisan make:model
            $this->call('make:model', ['name' => $nameFolder]);

            // Obtener columnas de la tabla correspondiente
            $columns = Schema::getColumnListing($tableName);

            // Excluir columnas 'id', 'created_at', y 'updated_at'
            $fillable = array_filter($columns, function ($column) {
                return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
            });

            $fillableArray = "['" . implode("', '", $fillable) . "']";

            // Ruta al archivo del modelo
            $modelPath = app_path("Models/{$nameFolder}.php");

            // Leer el contenido del modelo generado
            $modelContent = file_get_contents($modelPath);

            // Insertar $table, $fillable, y SoftDeletes en el modelo
            $modelContent = str_replace(
                "use Illuminate\Database\Eloquent\Model;",
                "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\SoftDeletes;",
                $modelContent
            );
            $modelContent = str_replace(
                "use HasFactory;",
                "use HasFactory, SoftDeletes;\n\n    protected \$table = '$tableName';\n\n    protected \$fillable = $fillableArray;",
                $modelContent
            );

            // Insertar scopes personalizados
            // $modelContent = str_replace(
            //     "}\n",
            //     "\n    public function scopeListado(\$query)\n    {\n        // Define the listado scope\n    }\n\n    public function scopeSearch(\$query, \$term)\n    {\n        // Define the search scope\n    }\n}\n",
            //     $modelContent
            // );

            // Escribir el contenido modificado de nuevo al archivo
            file_put_contents($modelPath, $modelContent);

            $this->info("Model $name created with custom configurations.");
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
