<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Services\Role\RoleService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * The service instance
     *
     * @var RoleService
     */
    protected $roleService;

    /**
     * Constructor
     */
    public function __construct(RoleService $service)
    {
        $this->roleService = $service;
    }
    
    /**
     * Handle search data
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('search', Role::class);

        return $this->roleService->index($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $input = $request->validated();
        $record = $this->roleService->create($input);
        if (! is_null($record)) {
            return $this->responseStoreSuccess(['record' => $record]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('edit', Role::class);

        $data = $request->validated();
        if ($this->roleService->update($role, $data)) {
            return $this->responseUpdateSuccess(['record' => $role->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', Role::class);

        if ($this->roleService->delete($role)) {
            return $this->responseDeleteSuccess(['record' => $role]);
        }

        return $this->responseDeleteFail();
    }
}
