<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();
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
        return ServiceResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create_service');

        $data = $request->validated();
        $newservice = Service::query()->create($data);

        if ($newservice) {
            return $this->responseStoreSuccess(['record' => $newservice]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $model = new ServiceResource($service);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        try {
            $this->authorize('edit_service');

            $data = $request->validated();
            $newservice = $service->update($data);

            if ($newservice) {
                return $this->responseUpdateSuccess(['record' => $service]);
            } else {
                return $this->responseUpdateFail();
            }
        } catch (QueryException $e) {
            return $this->responseFail(getQueryErrors($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $name = $service->name;
        $this->authorize('delete_service');
        $service->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
