<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Pages\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Menu::query();
        if (! empty($request['search'])) {
            $query = $query->search($request['search']);
        }

        if (! empty($request['sort_by']) && ! empty($request['sort'])) {
            $query = $query->orderBy($request['sort_by'], $request['sort']);
        }

        //Response json con paginación
        return responseMetaLinks($query, 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Archivos de las plantillas en la carpeta
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StoreMenuRequest $request)
    // {
    //     $this->authorize('create_template');

    //     $data = $request->validated();
    //     $newrecord = Menu::query()->create($data);

    //     if ($newrecord) {
    //         return $this->responseUpdateSuccess(['record' => $newrecord]);
    //     } else {
    //         return $this->responseUpdateFail();
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(Menu $template)
    {
        $model = new MenuResource($template);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateMenuRequest $request, Menu $template)
    // {
    //     $this->authorize('edit_template');

    //     $data = $request->validated();
    //     $newrecord = Menu::query()->update($data);

    //     if ($newrecord) {
    //         return $this->responseUpdateSuccess(['record' => $newrecord]);
    //     } else {
    //         return $this->responseUpdateFail();
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $template)
    {
        $name = $template->name;
        $this->authorize('delete_template');
        $template->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
