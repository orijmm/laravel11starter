<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbilityToRoleRequest;
use App\Http\Requests\StoreAbilityRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateAbilityRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Ability;
use App\Models\Role;
use App\Services\Role\RoleService;
use App\Utilities\Data;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
     * Display a listing of the resource.
     *
     * @return JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('list', Role::class);

        return $this->roleService->index($request->all());
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

        return $this->roleService->search($request->all());
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
     *  Show the form for editing the specified resource.
     *
     *
     * @return RoleResource|JsonResponse
     *
     * @throws AuthorizationException
     */
    public function show(Role $user)
    {
        $this->authorize('view', Role::class);

        $model = $this->roleService->get($user);

        return $this->responseDataSuccess(['model' => $model, 'properties' => $this->properties()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return JsonResponse|\Illuminate\Http\Response
     *
     * @throws AuthorizationException
     */
    public function edit(Role $role)
    {
        $this->authorize('edit', Role::class);

        return $this->show($role);
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

    /**
     * Add Ability to rol.
     */
    public function assignAbilityToRole(AbilityToRoleRequest $request, Role $role)
    {
        $this->authorize('edit', Role::class);

        $data = $request->validated();
        if ($this->roleService->assignAbility($role, $data)) {
            return $this->responseUpdateSuccess(['record' => $role->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    public function allAbilities(Request $request)
    {
        $this->authorize('list', Role::class);

        $query = Ability::query();
        if (! empty($request['search'])) {
            $query = $query->search($request['search']);
        }

        //Response json con paginación
        return responseMetaLinks($query, 10);
    }

    public function abilitiesSelect(Request $request)
    {
        $abilities = [];
        $query = Ability::query();
        if (! empty($request['search'])) {
            $query = $query->search($request['search']);
        }
        if ($query) {
            //Se trasnforma a id/label
            $abilities = Data::formatCollectionForSelect($query->get());
        }
        return response()->json(['data' => $abilities], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function createAbility(StoreAbilityRequest $request)
    {
        $this->authorize('edit', Role::class);

        $data = $request->validated();

        $ability = $this->roleService->createAbility($data);

        if ($ability) {
            return $this->responseUpdateSuccess(['record' => $ability]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateAbility(UpdateAbilityRequest $request, Ability $ability)
    {
        $this->authorize('edit', Role::class);

        $data = $request->validated();

        if ($ability->update($data)) {
            return $this->responseUpdateSuccess(['record' => $ability->fresh()]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteAbility(Ability $ability)
    {
        $this->authorize('delete', Role::class);
            
        if ($ability->delete()) {
            return $this->responseDeleteSuccess(['record' => $ability]);
        }

        return $this->responseDeleteFail();
    }

    /**
     * Render properties
     *
     * @return array
     */
    public function properties()
    {
        return [];
    }
}
