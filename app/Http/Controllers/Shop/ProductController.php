<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{ProductResource};
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Shop\Product;
use Illuminate\Support\Facades\DB;

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
        $this->authorize('edit_shop');
        try {
            DB::beginTransaction();
            $data = $request->validated();

            // 1) Crear el producto
            $product = Product::query()->create($data);

            // 2) Relacionar atributos (si vienen)
            if ($request->filled('attributes') && is_array($data['attributes'])) {
                foreach ($data['attributes'] as $attr) {
                    if (!is_array($attr)) {
                        continue; // evita errores si algún elemento es booleano
                    }
                    //TODO Revisar porque no guardó product_attribute_product
                    DB::table('product_attribute_product')->insert([
                        'product_id'                  => $product->id,
                        'product_attribute_id'         => $attr['attribute_id'],
                        'product_attribute_option_id'  => $attr['option_id'],
                        'created_at'                   => now(),
                        'updated_at'                   => now()
                    ]);
                }
            }


            // 3) Crear variantes (si vienen)
            if ($request->has('variants')) {
                foreach ($data['variants'] as $var) {
                    $product->variants()->create([
                        'title'         => $var['title'],
                        'sku'           => $var['sku'],
                        'price'         => $var['price'],
                        'compare_price' => $var['compare_price'] ?? null,
                        'currency'      => $var['currency'] ?? 'CLP',
                        'stock'         => $var['stock'],
                        'is_active'     => $var['is_active'] ?? 1,
                        'is_default'    => $var['is_default'] ?? 0,
                        'specs'         => $var['specs']
                    ]);
                }
            }

            // 4) Actualizar has_stock según variantes
            $product->update([
                'has_stock' => $product->variants()->sum('stock') > 0
            ]);

            DB::commit();

            return $this->responseStoreSuccess(['record' => $product->load(['variants'])]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail($e->getMessage(), [], 500);
        }
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
