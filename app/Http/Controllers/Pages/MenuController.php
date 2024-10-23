<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Pages\Menu;
use App\Models\Pages\MenuItem;
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
        return MenuResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $this->authorize('create_menu');

        $data = $request->validated();
        $newmenu = Menu::query()->create($data);

        if ($newmenu) {
            return $this->responseUpdateSuccess(['record' => $newmenu]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $model = new MenuResource($menu);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $this->authorize('edit_menu');

        $data = $request->validated();
        $newmenu = $menu->update($data);
        $createdItems = [];
        if ($newmenu) {
            //Agregar item si tiene
            if ($data['items'] ?? false) {
                //foreach ($data['items'] as $k => $itemData) {
                    $comments = array_map(function($data) {
                        return new MenuItem($data);
                    }, $data['items']);
                    $menu->items()->saveMany($comments);
                    // $menu->items[$k]->label = $itemData['label'];
                    // $menu->items[$k]->url = $itemData['url'];
                    // $menu->items[$k]->description = $itemData['description'] ?? null;
                    // $menu->items[$k]->order = $itemData['order'];
                    // $menu->items[$k]->parent_id = $itemData['parent_id'] ?? null;
                    // $menu->items[$k]->page_id = $itemData['page_id'] ?? null;
                //}
            }
            return $this->responseUpdateSuccess(['record' => $menu]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $name = $menu->name;
        $this->authorize('delete_menu');
        $menu->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
