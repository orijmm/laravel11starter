<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Str;

class ControllerRequestModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller-request-model {model} {folder?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea controlador y store/update request. La tabla debe estar creada';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            //Argumentos
            $modelName = $this->argument('model');
            $modelPath = app_path("Models/{$modelName}.php");//opcional
            //Nombre tabla se convierte en plural y a snake case
            $tableName = Str::snake(Str::pluralStudly($modelName));

            $modelFolder = $this->argument('folder');

            $flagExistModel = true;
            if (!File::exists($modelPath)) {
                $this->call('make:model', ['name' => $modelFolder ? $modelFolder . "\\" . $modelName : $modelName]);
                $flagExistModel = false;
            }

            $modelClass = $modelFolder ? "App\\Models\\{$modelFolder}\\{$modelName}" : "App\\Models\\{$modelName}";
            $tableName = (new $modelClass)->getTable();

            // Obtener columnas de la tabla
            $columns = Schema::getColumnListing($tableName);

            // Filtrar columnas 'id', 'created_at', y 'updated_at'
            $fillable = array_filter($columns, function ($column) {
                return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
            });
            // Generar archivos
            if(!$flagExistModel){
                $this->modelContent($modelName, $fillable, $tableName, $modelFolder);
            }
            $this->createController($modelName, $modelFolder);
            $this->modelResource($modelName);
            $this->createStoreRequest($modelName, $fillable, $tableName);
            $this->createUpdateRequest($modelName, $fillable);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function createController($modelName, $modelFolder = null)
    {
        try {
            $controllerName = $modelFolder ? "{$modelFolder}\\{$modelName}Controller" : "{$modelName}Controller";
            Artisan::call('make:controller', ['name' => $controllerName, '--resource' => true, '--model' => $modelFolder ? "{$modelFolder}/{$modelName}" : $modelName, '--requests' => true, '--api' => true]);
            $this->info("Controller $controllerName created successfully.");
        } catch (\Exception $e) {
            $this->warn("Error: " . $e->getMessage());
        }
    }

    protected function createStoreRequest($modelName, $fillable, $tableName = null)
    {
        try {
            $requestName = "Store{$modelName}Request";
            $modelPath = app_path("Http/Requests/{$requestName}.php");

            // $columnsNullable = Schema::getColumns($tableName);

            
            $fields = collect($fillable)->map(function ($field) {
                // $this->info(json_encode($columnsNullable, JSON_PRETTY_PRINT));
                return "'$field' => 'required',";
            })->implode("\n            ");

            // Leer el contenido del modelo generado
            $modelContent = file_get_contents($modelPath);

            // Insertar $table, $fillable, y SoftDeletes en el modelo
            $modelContent = str_replace(
                "return false;",
                "return true;",
                $modelContent
            );
            $modelContent = str_replace(
                "//",
                $fields,
                $modelContent
            );

            file_put_contents($modelPath, $modelContent);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function createUpdateRequest($modelName, $fillable)
    {
        try {
            $requestName = "Update{$modelName}Request";
            $modelPath = app_path("Http/Requests/{$requestName}.php");

            $fields = collect($fillable)->map(function ($field) {
                return "'$field' => 'required',";
            })->implode("\n            ");

            // Leer el contenido del modelo generado
            $modelContent = file_get_contents($modelPath);

            // Insertar $table, $fillable, y SoftDeletes en el modelo
            $modelContent = str_replace(
                "return false;",
                "return true;",
                $modelContent
            );
            $modelContent = str_replace(
                "//",
                $fields,
                $modelContent
            );

            file_put_contents($modelPath, $modelContent);
            $this->info("Request $requestName created successfully.");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function modelResource($modelName)
    {
        try {
            //Crear ModeloResources.php
            $resourceName = "{$modelName}Resource"; // Nombre del recurso que vas a crear
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
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function modelContent($modelName, $fillable, $tableName,  $modelFolder = null)
    {
        try {
            $fillableArray = "['" . implode("', '", $fillable) . "']";

            $model = $modelFolder ? "{$modelFolder}\\{$modelName}" : $modelName;
            // Ruta al archivo del modelo
            $modelPath = app_path("Models/{$model}.php");

            // Leer el contenido del modelo generado
            $modelContent = file_get_contents($modelPath);

            // Insertar $table, $fillable, y SoftDeletes en el modelo
            $modelContent = str_replace(
                "use Illuminate\Database\Eloquent\Model;",
                "use Illuminate\Database\Eloquent\Model;\nuse Illuminate\Database\Eloquent\SoftDeletes;",
                $modelContent
            );
            $modelContent = str_replace(
                "//",
                "use SoftDeletes;\n\n    protected \$table = '$tableName';\n\n    protected \$fillable = $fillableArray;",
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
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
