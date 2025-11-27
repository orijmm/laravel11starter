<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\{PromotionResource};
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Shop\Promotion;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Promotion::query();

        if (!empty($request->search)) {
            $query = $query->search($request->search);
        }

        if (!empty($request->filters)) {
            filter($query, $request->filters);
        }

        if (!empty($request->sort_by) && !empty($request->sort)) {
            $query = $query->orderBy($request->sort_by, $request->sort);
        }

        return PromotionResource::collection($query->paginate(10));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        $this->authorize('edit_shop');

        try {
            DB::beginTransaction();

            // 1) Datos validados
            $data = $request->validated();

            // 2) Crear la promoción
            $promotion = Promotion::create($data);

            // 3) Guardar targets si vienen
            if (!empty($data['targets'])) {
                foreach ($data['targets'] as $item) {
                    $promotion->targets()->create([
                        'target_type' => $item['type'],   // product, variant, category, brand
                        'target_id'   => $item['id'],
                    ]);
                }
            }

            // 4) Guardar exclusiones si vienen (opcional)
            if (!empty($data['exclusions'])) {
                foreach ($data['exclusions'] as $item) {
                    $promotion->exclusions()->create([
                        'target_type' => $item['type'],
                        'target_id'   => $item['id'],
                    ]);
                }
            }

            DB::commit();

            return $this->responseStoreSuccess([
                'record' => $promotion->load(['targets', 'exclusions'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail($e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        return new PromotionResource($promotion->load(['targets', 'exclusions']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $this->authorize('edit_shop');

        try {
            DB::beginTransaction();

            // 1) Datos validados
            $data = $request->validated();

            // 2) Actualizar la promoción
            $promotion->update($data);

            // 3) Actualizar targets
            if (isset($data['targets'])) {
                $promotion->targets()->delete();
                foreach ($data['targets'] as $item) {
                    $promotion->targets()->create([
                        'target_type' => $item['type'],   // product, variant, category, brand
                        'target_id'   => $item['id'],
                    ]);
                }
            }

            // 4) Actualizar exclusiones
            if (isset($data['exclusions'])) {
                $promotion->exclusions()->delete();
                foreach ($data['exclusions'] as $item) {
                    $promotion->exclusions()->create([
                        'target_type' => $item['type'],
                        'target_id'   => $item['id'],
                    ]);
                }
            }

            DB::commit();

            return $this->responseUpdateSuccess([
                'record' => $promotion->load(['targets', 'exclusions'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseFail($e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $this->authorize('edit_shop');

        try {
            $promotion->delete();
            return $this->responseDeleteSuccess();
        } catch (\Exception $e) {
            return $this->responseFail($e->getMessage(), [], 500);
        }
    }

    #json
    //     {
    //     "title": "Promo 30% Poleras",
    //     "type": "percent",
    //     "value": 30,
    //     "start_at": "2025-01-01 00:00:00",
    //     "end_at": "2025-06-10 23:59:59",
    //     "is_active": true,
    //     "targets": [
    //         { "type": "category", "id": 5 },
    //         { "type": "brand", "id": 3 },
    //         { "type": "product", "id": 25 }
    //     ],
    //     "exclusions": [
    //         { "type": "brand", "id": 99 }
    //     ]
    // }

}
