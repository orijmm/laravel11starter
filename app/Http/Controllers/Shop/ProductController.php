<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{ProductResource};
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Shop\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $query = Product::query();

        if (!empty($request->search)) {
            $query = $query->search($request->search);
        }

        if (!empty($request->filters)) {
            filter($query, $request->filters);
        }

        if (!empty($request->sort_by) && !empty($request->sort)) {
            $query = $query->orderBy($request->sort_by, $request->sort);
        }

        return ProductResource::collection($query->paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
