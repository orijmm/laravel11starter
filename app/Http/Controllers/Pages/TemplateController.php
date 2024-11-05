<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTemplateRequest;
use App\Http\Requests\UpdateTemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Template::query();
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
    public function store(StoreTemplateRequest $request)
    {
        $this->authorize('create_template');

        $data = $request->validated();
        $newrecord = Template::query()->create($data);

        if ($newrecord) {
            return $this->responseUpdateSuccess(['record' => $newrecord]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $model = new TemplateResource($template);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $this->authorize('edit_template');

        $data = $request->validated();
        $newrecord = $template->update($data);

        if ($newrecord) {
            return $this->responseUpdateSuccess(['record' => $newrecord]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        $name = $template->name;
        $this->authorize('delete_template');
        $template->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }

}
