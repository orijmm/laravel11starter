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
            if ($request->has('attributes') && is_array($data['attributes'])) {
                $syncData = collect($data['attributes'])
                    ->filter(fn($attr) => is_array($attr))
                    ->mapWithKeys(fn($attr) => [
                        $attr['attribute_id'] => ['product_attribute_option_id' => $attr['option_id']]
                    ])
                    ->toArray();
                
                $product->attributes()->attach($syncData);
            }

            // 3) Crear variantes (si vienen)
            if ($request->has('variants') && is_array($data['variants'])) {
                $variantsData = collect($data['variants'])
                    ->filter(fn($var) => is_array($var))
                    ->map(fn($var) => [
                        'title'         => $var['title'],
                        'sku'           => $var['sku'],
                        'price'         => $var['price'],
                        'compare_price' => $var['compare_price'] ?? null,
                        'currency'      => $var['currency'] ?? 'CLP',
                        'stock'         => $var['stock'],
                        'is_active'     => $var['is_active'] ?? 1,
                        'is_default'    => $var['is_default'] ?? 0,
                        'specs'         => $var['specs']
                    ])
                    ->toArray();
                
                $product->variants()->createMany($variantsData);
            }

            // 4) Actualizar has_stock según variantes
            $product->update([
                'has_stock' => $product->variants()->sum('stock') > 0
            ]);

            DB::commit();

            return $this->responseStoreSuccess(['record' => $product->load(['variants', 'attributes'])]);
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
        $model = new ProductResource($product->loadMissing(['categories', 'variants', 'attributes', 'promotions']));
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('edit_shop');
        try {
            DB::beginTransaction();
            $data = $request->validated();

            // Actualizar el producto
            $product->update($data);

            // Actualizar atributos (si vienen)
            if ($request->has('attributes') && is_array($data['attributes'])) {
                $syncData = collect($data['attributes'])
                    ->filter(fn($attr) => is_array($attr))
                    ->mapWithKeys(fn($attr) => [
                        $attr['attribute_id'] => ['product_attribute_option_id' => $attr['option_id']]
                    ])
                    ->toArray();
                
                $product->attributes()->sync($syncData);
            }

            // Actualizar variantes (si vienen)
            if ($request->has('variants') && is_array($data['variants'])) {
                collect($data['variants'])
                    ->filter(fn($var) => is_array($var) && isset($var['id']))
                    ->each(function ($varData) use ($product) {
                        $product->variants()->where('id', $varData['id'])->update([
                            'title'         => $varData['title'],
                            'sku'           => $varData['sku'],
                            'price'         => $varData['price'],
                            'compare_price' => $varData['compare_price'] ?? null,
                            'currency'      => $varData['currency'] ?? 'CLP',
                            'stock'         => $varData['stock'],
                            'is_active'     => $varData['is_active'] ?? 1,
                            'is_default'    => $varData['is_default'] ?? 0,
                            'specs'         => $varData['specs']
                        ]);
                    });
            }

            // Actualizar has_stock según variantes
            $product->update([
                'has_stock' => $product->variants()->sum('stock') > 0
            ]);

            DB::commit();
            return $this->responseUpdateSuccess(['record' => $product->load(['variants', 'attributes'])]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail($e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
