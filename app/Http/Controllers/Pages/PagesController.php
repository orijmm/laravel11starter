<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Pages\Page;
use App\Models\Pages\Row;
use App\Models\Pages\Section;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Page::query()->with(['sections', 'template']);
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
        return PageResource::collection($query->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        $this->authorize('create_page');

        $data = $request->validated();
        //plantilla
        $data['template_id'] = $data['template_id']['id'];
        $newPage = Page::query()->create($data);

        if ($newPage) {
            return $this->responseStoreSuccess(['record' => $newPage]);
        } else {
            return $this->responseStoreFail();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        $model = new PageResource($page);
        return $this->responseDataSuccess(['model' => $model]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $this->authorize('edit_page');

        $data = $request->validated();
        $data['template_id'] = $data['template_id']['id'];
        $newPage = $page->update($data);

        if ($newPage) {
            return $this->responseUpdateSuccess(['record' => $page]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    ############ SECTIONS ##############
    public function showSection(Page $page, Section $section)
    {
        $model = Section::where('id', $section->id)->with(['rows' => function (Builder $query) {
            $query->select('id', 'order', 'section_id')->orderBy('order', 'asc');
        }])->first();
        return $this->responseDataSuccess(['model' => $model]);
    }

    public function storeSection(Request $request, Page $page)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'backgroundcolor' => 'nullable',
            'order' => 'required|integer',
            'textcolor' => 'nullable',
        ]);

        $section = new Section($data);

        #Agregar relacion a page
        $newsection = $page->sections()->save($section);
        if ($newsection) {
            return $this->responseStoreSuccess(['record' => $newsection]);
        } else {
            return $this->responseStoreFail();
        }
    }

    public function updateSection(Request $request, Section $section)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'backgroundcolor' => 'nullable',
            'order' => 'required|integer',
            'textcolor' => 'nullable',
        ]);
        $edititem = $section->update($data);

        if ($edititem) {
            return $this->responseUpdateSuccess(['record' => $section]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    public function deleteSection(Section $section)
    {
        $this->authorize('delete_page');
        $section->delete();
        return $this->responseDeleteSuccess();
    }

    ###### ROWS ######
    public function updateRows(Request $request, Section $section)
    {
        try {
            $rows = $request->rows;
            $order = 1;
            // Obtener los IDs de las filas actuales de la base de datos
            $currentRowIds = $section->rows->pluck('id')->toArray();

            // Extraer los IDs de las filas enviadas desde el front-end
            $rowIdsFromRequest = array_column($rows, 'id');

            // Filas que deben ser eliminadas
            $rowsToDelete = array_diff($currentRowIds, $rowIdsFromRequest);
            Row::destroy($rowsToDelete);

            // Crear o actualizar las filas
            // foreach ($rows as $rowData) {
            //     $section->rows()->updateOrCreate(
            //         ['id' => $rowData['id'] ?? null], // Condición: buscar por ID (si existe)
            //         ['order' => $order++]   // Datos a actualizar o crear
            //     );
            // }
            return $this->responseUpdateSuccess(['record' => [$currentRowIds, $rowIdsFromRequest, $rowsToDelete]]);
        } catch (\Exception $e) {
            return $this->responseUpdateFail(['error' => $e->getMessage()]);
        }
    }
    ###### COLUMS ######
    ###### COMPONENTS ######
}
