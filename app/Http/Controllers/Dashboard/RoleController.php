<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();

        return sendResponse($roles, 'Roles retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name'          => 'required|unique:roles'
        ]);

        $role = Role::create($input);

        return sendResponse($role, 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if (is_null($role)) {
            return sendError('Role not found.');
        }

        return sendResponse($role, 'Role retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $input = $request->all();

        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('roles')->ignore($role->id)
            ]
        ]);


        $role->name = $input['name'];
        $role->save();

        return sendResponse($role, 'Role updated successfully.');
    }

    /**
     * Assign roles to an user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assingRole(Request $request, User $user)
    {
        $input = $request->all();

        $validated = $request->validate([
            'roles'          => 'bail|required'
        ]);

        //Get all roles
        $allRoles = Role::pluck('id')->all();

        $user->assignRole('writer');

        //dont add roles than not exist
        $rolesExist = array_intersect($allRoles, $input['roles']);

        //asign [] of roles
        $user->roles()->sync($rolesExist);

        return sendResponse($user, 'Roles asigned successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return sendResponse([], 'Role deleted');
    }
}
