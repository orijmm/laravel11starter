<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Str;

class ControllerRequestResourceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:controller-request-resource {model} {folder?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para crear controlador, request de store/update y resource para un modelo existente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            //Argumentos
            $modelName = $this->argument('model');
            //Nombre tabla se convierte en plural y a snake case
            $tableName = Str::snake(Str::pluralStudly($modelName));

            $modelFolder = $this->argument('folder');

            $modelClass = $modelFolder ? "App\\Models\\{$modelFolder}\\{$modelName}" : "App\\Models\\{$modelName}";
            $tableName = (new $modelClass)->getTable();

            // Obtener columnas de la tabla
            $columns = Schema::getColumnListing($tableName);

            $this->createController($modelName, $modelFolder);
            $this->modelResource($modelName);
            $this->createStoreRequest($modelName, $tableName);
            $this->createUpdateRequest($modelName, $tableName);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }

    protected function createController($modelName, $modelFolder = null)
    {
        try {
            $controllerName = $modelFolder ? "{$modelFolder}\\{$modelName}Controller" : "{$modelName}Controller";
            Artisan::call('make:controller', ['name' => $controllerName, '--resource' => true, '--model' => $modelFolder ? "{$modelFolder}/{$modelName}" : $modelName, '--requests' => true, '--api' => true]);
            // Insertar método index custom
            $this->insertCustomIndexMethod($controllerName, $modelName, $modelFolder);
            $this->info("Controller $controllerName created successfully.");
        } catch (\Exception $e) {
            $this->warn("Error: " . $e->getMessage());
        }
    }

    protected function createStoreRequest($modelName, $tableName = null)
    {
        try {
            $requestName = "Store{$modelName}Request";
            $modelPath = app_path("Http/Requests/{$requestName}.php");

            $columns = DB::getSchemaBuilder()->getColumns($tableName);

            $fields = '';
            foreach ($columns as $column) {
                $type = DB::getSchemaBuilder()->getColumnType($tableName, $column['name']);
                $isNullable = $column['nullable'];
                if (!in_array($column['name'], ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                    if ($column['name'] === 'slug') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|alpha_dash|unique:{$tableName}',\n            ";
                    } elseif ($type === 'string' || $type === 'text') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|string',\n            ";
                    } elseif ($type === 'int' || $type === 'bigint' || $type === 'smallint') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|integer',\n            ";
                    } elseif ($type === 'boolean' || $type === 'tinyint') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|boolean',\n            ";
                    } elseif ($type === 'date') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date',\n            ";
                    } elseif ($type === 'datetime') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date_format:Y-m-d H:i:s',\n            ";
                    } elseif ($type === 'timestamp') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date_format:Y-m-d H:i:s',\n            ";
                    } else {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|string',\n            ";
                    }
                }
            }

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

    protected function createUpdateRequest($modelName, $tableName)
    {
        try {
            $requestName = "Update{$modelName}Request";
            $modelPath = app_path("Http/Requests/{$requestName}.php");

            $columns = DB::getSchemaBuilder()->getColumns($tableName);

            $fields = '';
            foreach ($columns as $column) {
                $type = DB::getSchemaBuilder()->getColumnType($tableName, $column['name']);
                $isNullable = $column['nullable'];
                if (!in_array($column['name'], ['id', 'created_at', 'updated_at', 'deleted_at'])) {
                    if ($column['name'] === 'slug') {
                        $fields .= "'{$column['name']}' => '"
                            . ($isNullable ? 'nullable' : 'required')
                            . "|alpha_dash|unique:{$tableName},slug,' . \$this->route('" . Str::snake($modelName) . "')->id,\n            ";
                    }
                    if ($type === 'string' || $type === 'text') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|string',\n            ";
                    } elseif ($type === 'int' || $type === 'bigint' || $type === 'smallint') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|integer',\n            ";
                    } elseif ($type === 'boolean' || $type === 'tinyint') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|boolean',\n            ";
                    } elseif ($type === 'date') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date',\n            ";
                    } elseif ($type === 'datetime') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date_format:Y-m-d H:i:s',\n            ";
                    } elseif ($type === 'timestamp') {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "|date_format:Y-m-d H:i:s',\n            ";
                    } else {
                        $fields .= "'{$column['name']}' => '" . ($isNullable ? 'nullable' : 'required') . "'";
                    }
                }
            }

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

    protected function insertCustomIndexMethod($controllerName, $modelName, $modelFolder)
    {
        // Ubicación real del archivo generado
        $path = app_path('Http/Controllers/' . str_replace('\\', '/', $controllerName) . '.php');

        if (! file_exists($path)) {
            $this->warn("Controller file not found: $path");
            return;
        }

        $snakeModel = \Str::camel($modelName);
        $resourceName = $modelName . 'Resource';

        // Método index personalizado
        $indexMethod = <<<PHP

    public function index(Request \$request)
    {
        \$query = {$modelName}::query();

        if (!empty(\$request->search)) {
            \$query = \$query->search(\$request->search);
        }

        if (!empty(\$request->filters)) {
            filter(\$query, \$request->filters);
        }

        if (!empty(\$request->sort_by) && !empty(\$request->sort)) {
            \$query = \$query->orderBy(\$request->sort_by, \$request->sort);
        }

        return {$resourceName}::collection(\$query->paginate(10));
    }

PHP;

        // Leer el archivo
        $controller = file_get_contents($path);

        // Reemplazar el método vacío que genera Laravel
        $controller = preg_replace(
            '/public function index\(.*?\{.*?\}/s',
            $indexMethod,
            $controller
        );

        $controller = str_replace(
                "use App\Http\Controllers\Controller;",
                "use App\Http\Controllers\Controller;\nuse Illuminate\Http\Request;\nuse App\Http\Resources\{$resourceName};",
                $controller
            );

        // Guardar cambios
        file_put_contents($path, $controller);
    }
}
