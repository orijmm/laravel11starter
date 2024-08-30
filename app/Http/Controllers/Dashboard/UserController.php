<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = User::get();
        return sendResponse($result, 'Consulta Exitosa');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::where('id', $id)->get();
        return sendResponse($users, 'Consulta Exitosa');
    }

    public function listSelect(Request $request)
    {
        try {
            $search = $request->search ?? null;
            $usersSelect = User::getSelect()
                ->when($search, function (Builder $query, string $search) {
                    $query->where('name' , 'like', '%'.$search.'%');
                })
                ->get();

            return sendResponse($usersSelect, 'Consulta Exitosa');
        } catch (\Exception $e) {
            return sendError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
