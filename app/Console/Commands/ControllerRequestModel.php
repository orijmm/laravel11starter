<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ControllerRequestModel extends Command
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
    protected $description = 'Crea controlador y store/update request';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = $this->argument('model');
        $modelFolder = $this->argument('folder');
        $modelClass = $modelFolder ? "App\\Models\\{$modelFolder}\\{$modelName}" : "App\\Models\\{$modelName}";
        $tableName = (new $modelClass)->getTable();

        // Obtener columnas de la tabla
        $columns = Schema::getColumnListing($tableName);

        // Filtrar columnas 'id', 'created_at', y 'updated_at'
        $fillable = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at', 'deleted_at']);
        });

        // Generar archivos
        $this->createController($modelName, $modelFolder);
        $this->modelResource($modelName);
        $this->createStoreRequest($modelName, $fillable);
        $this->createUpdateRequest($modelName, $fillable);
    }

    protected function createController($modelName, $modelFolder = null)
    {
        $controllerName = $modelFolder ? "{$modelFolder}\\{$modelName}Controller" : "{$modelName}Controller";
        Artisan::call('make:controller', ['name' => $controllerName, '--resource' => true, '--model' => "Pages/{$modelName}", '--requests' => true, '--api' => true]);
        $this->info("Controller $controllerName created successfully.");
    }

    protected function createStoreRequest($modelName, $fillable)
    {
        $requestName = "Store{$modelName}Request";
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
    }

    protected function createUpdateRequest($modelName, $fillable)
    {
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
    }

    protected function modelResource($modelName)
    {
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
    }
}
