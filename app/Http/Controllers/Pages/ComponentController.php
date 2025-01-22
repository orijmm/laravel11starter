<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentRequest;
use App\Http\Requests\UpdateComponentRequest;
use App\Http\Resources\ComponentResource;
use App\Models\Pages\Component;
use Illuminate\Http\Request;
use App\Services\Media\MediaService;

class ComponentController extends Controller
{
    /**
     * The service instance
     *
     * @var MediaService
     */
    protected $mediaService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Component::query()->with(['componenttype']);
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
            return ComponentResource::collection($query->paginate(10));
        } catch (\Exception $e) {
            return $this->responseFail($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComponentRequest $request)
    {
        $this->authorize('create_page');

        $data = $request->validated();
        //plantilla
        $data['component_type_id'] = $data['component_type_id']['id'];
        $newcomponent = Component::query()->create($data);

        if ($newcomponent) {
            return $this->responseStoreSuccess(['record' => $newcomponent]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Component $component)
    {
        $model = new ComponentResource($component);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComponentRequest $request, Component $component)
    {
        $this->authorize('edit_page');

        $data = $request->validated();
        $data['component_type_id'] = $data['component_type_id']['id'];
        if (!isset($request->contents)) {
            $data['contents'] = [];
        }

        if (! empty($request->img)) {
            $this->mediaService->replace($request->img, $component, 'componentimg');
        }

        $newcomponent = $component->update($data);

        if ($newcomponent) {
            return $this->responseUpdateSuccess(['record' => $component, $request->contents]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Component $component)
    {
        $name = $component->name;
        $this->authorize('delete_page');
        $component->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
