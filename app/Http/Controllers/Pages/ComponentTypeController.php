<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentTypeRequest;
use App\Http\Requests\UpdateComponentTypeRequest;
use App\Http\Resources\ComponentTypeResource;
use App\Models\Pages\ComponentType;
use Illuminate\Http\Request;

class ComponentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = ComponentType::query();
            if (! empty($request['search'])) {
                $query = $query->search($request['search']);
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
    public function show(ComponentType $componentType)
    {
        $model = new ComponentTypeResource($componentType);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponentTypeRequest $request, ComponentType $componentType)
    {
        $this->authorize('edit_page');

        $data = $request->validated();
        $newcomponent_type = $componentType->update($data);

        if ($newcomponent_type) {
            return $this->responseUpdateSuccess(['record' => $componentType]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponentType $componentType)
    {
        $name = $componentType->name;
        $this->authorize('delete_page');
        $componentType->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
