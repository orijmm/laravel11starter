<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use ErrorException;
use Exception;
use Illuminate\Database\QueryException;
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
        try {
            $this->authorize('create_testimonial');

            $data = $request->validated();
            $newtestimonial = Testimonial::query()->create($data);

            if ($newtestimonial) {
                return $this->responseStoreSuccess(['record' => $newtestimonial]);
            } else {
                return $this->responseStoreFail();
            }
        } catch (ErrorException $e) {
            // Error inesperado
            return $this->responseFail($e->getMessage());
        } catch (QueryException $e) {
            return $this->responseFail(getQueryErrors($e));
        } catch (Exception $e) {
            // Error inesperado
            return $this->responseFail($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        $model = new TestimonialResource($testimonial);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestimonialRequest $request, Testimonial $testimonial)
    {
        try {
            $this->authorize('edit_testimonial');

            $data = $request->validated();
            $newtestimonial = $testimonial->update($data);

            if ($newtestimonial) {
                return $this->responseUpdateSuccess(['record' => $testimonial]);
            } else {
                return $this->responseUpdateFail();
            }
        } catch (QueryException $e) {
            return $this->responseFail(getQueryErrors($e));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $this->authorize('delete_testimonial');
        $testimonial->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }
}
