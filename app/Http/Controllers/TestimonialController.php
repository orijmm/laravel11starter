<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Testimonial::query();
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
        return TestimonialResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestimonialRequest $request)
    {
        $this->authorize('create_menu');

        $data = $request->validated();
        $newmenu = Testimonial::query()->create($data);

        if ($newmenu) {
            return $this->responseStoreSuccess(['record' => $newmenu]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $testimonial->load(['items.parent', 'items.page', 'items.menu', 'items.children']);
        $model = new TestimonialResource($testimonial);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        $this->authorize('edit_menu');

        $data = $request->validated();
        $newmenu = $testimonial->update($data);

        if ($newmenu) {
            return $this->responseUpdateSuccess(['record' => $testimonial]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $this->authorize('delete_menu');
        $testimonial->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
