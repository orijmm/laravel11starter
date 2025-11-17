<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{CategoryResource};
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Shop\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $query = Category::query()->with(['parent', 'children']);

        if (!empty($request->search)) {
            $query = $query->search($request->search);
        }

        if (!empty($request->filters)) {
            filter($query, $request->filters);
        }

        if (!empty($request->sort_by) && !empty($request->sort)) {
            $query = $query->orderBy($request->sort_by, $request->sort);
        }

        return CategoryResource::collection($query->paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('edit_shop');

        $data = $request->validated();
        //plantilla
        $data['parent_id'] = $data['parent_id'] ? $data['parent_id'] : null;
        $newcategory = Category::query()->create($data);

        if ($newcategory) {
            return $this->responseStoreSuccess(['record' => $newcategory]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $model = new CategoryResource($category->loadMissing(['parent', 'children']));
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $this->authorize('edit_shop');

            $data = $request->validated();
            $data['parent_id'] = $data['parent_id'] ? $data['parent_id'] : null;

            $updated = $category->update($data);

            if ($updated) {
                return $this->responseUpdateSuccess(['record' => $category]);
            } else {
                return $this->responseUpdateFail();
            }
        } catch (\Exception $e) {
            return $this->responseFail($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $this->authorize('edit_shop');

            if ($category->children()->count() > 0) {
                return $this->responseFail(trans('frontend.global.phrases.cannot_delete_record_with_relations'));
            }

            $deleted = $category->delete();

            if ($deleted) {
                return $this->responseDeleteSuccess();
            } else {
                return $this->responseDeleteFail();
            }
        } catch (\Exception $e) {
            return $this->responseFail($e);
        }
    }
}
