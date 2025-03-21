<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use App\Models\Pages\Menu;
use App\Models\Pages\MenuItem;
use App\Models\Pages\Page;
use App\Utilities\Data;
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

        if (! empty($request['filters'])) {
            filter($query, $request['filters']);
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
            return $this->responseStoreSuccess(['record' => $newmenu]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['items.parent', 'items.page', 'items.menu', 'items.children']);
        $model = new MenuResource($menu);
        return $this->responseDataSuccess(['model' => $model]);
    }

    public function showByName(Request $request)
    {
        $model = [];
        $menu = Menu::where('name', $request->search)->first();
        if($menu){
            $menu->load(['items.parent', 'items.page', 'items.menu', 'items.children']);
            $model = new MenuResource($menu);
        }
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

        if ($newmenu) {
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

    ############ ITEMS ##############
    public function showItem(Menu $menu, MenuItem $menuitem)
    {
        $itemsParents = $menu->items ?? [];
        //Select de parent y page
        $allItems = MenuItem::select('label as name', 'id')->get();
        $allpages = Page::select('title as name', 'id')->get();
        $menuitem['parent_id'] = Data::getSelectedLocation($allItems, $menuitem->parent_id, 'id', 'label');
        $menuitem['page_id'] = Data::getSelectedLocation($allpages, $menuitem->page_id, 'id', 'title');
        return $this->responseDataSuccess(['model' => $menuitem, 'parents' => $itemsParents]);
    }

    public function storeItem(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'label' => 'required|string|unique:menu_items',
            'url' => 'nullable',
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable',
            'page_id' => 'nullable',
        ]);

        $data['parent_id'] = $data['parent_id']['id'] ?? null;
        $data['page_id'] = $data['page_id']['id'] ?? null;

        $menuitem = new MenuItem($data);

        #Agregar relacion a menu
        $newitem = $menu->items()->save($menuitem);
        if ($newitem) {
            return $this->responseStoreSuccess(['record' => $newitem]);
        } else {
            return $this->responseStoreFail();
        }
    }

    public function updateItem(Menu $menu, MenuItem $menuitem, Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string',
            'url' => 'nullable|string|unique:menu_items,url,'.$menuitem->id,
            'description' => 'nullable|string',
            'order' => 'required|integer',
            'parent_id' => 'nullable',
            'page_id' => 'nullable',
        ]);

        $edititem = $menuitem->update($data);

        if ($edititem) {
            return $this->responseUpdateSuccess(['record' => $menuitem]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    public function deleteItem(MenuItem $menuitem)
    {
        $this->authorize('delete_menu');
        $menuitem->delete();
        return $this->responseDeleteSuccess();
    }
}
