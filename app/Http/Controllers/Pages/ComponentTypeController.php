<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentTypeRequest;
use App\Http\Requests\UpdateComponentTypeRequest;
use App\Http\Resources\ComponentTypeResource;
use App\Models\Pages\ComponentType;
use App\Utilities\Data;
use Illuminate\Http\Request;

class ComponentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //DB::listen(fn ($e) => dump($e->toRawSql()));
            $query = ComponentType::query()->with('components');
            if (! empty($request['search'])) {
                $query = $query->search($request['search']);
            }
            if (! empty($request['filters'])) {
                filter($query, $request['filters']);
            }
            if (! empty($request['sort_by']) && ! empty($request['sort'])) {
                $query = $query->orderBy($request['sort_by'], $request['sort']);
            }

            //Response json con paginación
            return ComponentTypeResource::collection($query->paginate(10));
        } catch (\Exception $e) {
            return $this->responseFail($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponentTypeRequest $request)
    {
        $this->authorize('create_page');

        $data = $request->validated();
        $data['name'] = ucfirst($data['name']);//Capitalize
        $data['filename'] = $data['filename']['name'];//select
        $newcomponent_type = ComponentType::query()->create($data);

        if ($newcomponent_type) {
            return $this->responseStoreSuccess(['record' => $newcomponent_type]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ComponentType $componenttype)
    {
        $model = new ComponentTypeResource($componenttype);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponentTypeRequest $request, ComponentType $componenttype)
    {
        $this->authorize('edit_page');

        $data = $request->validated();
        $data['name'] = ucfirst($data['name']);//Capitalize
        $data['filename'] = $data['filename']['name'];//select
        $newcomponent_type = $componenttype->update($data);

        if ($newcomponent_type) {
            return $this->responseUpdateSuccess(['record' => $componenttype]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponentType $componenttype)
    {
        $name = $componenttype->name;
        $this->authorize('delete_page');
        $componenttype->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }

    public function listFilename(Request $request)
    {
        try {
            // Define la ruta absoluta a la carpeta "components"
            $path = resource_path('app/views/pages/public/components');
            //Funcion extrae nombres archivos segun path
            $fileFolderNames = Data::getFilenameByFolder($path);
            //Buscar
            if ($request->search) {
                $fileFolderNames = filterArrObj($fileFolderNames, $request->search, 'name');
            }
            return $this->responseDataSuccess(['data' => $fileFolderNames]);
        } catch (\Exception $e) {
            return $this->responseFail($e);
        }
    }
}
