<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComponentRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Models\Pages\Column;
use App\Models\Pages\Component;
use App\Models\Pages\MenuItem;
use App\Models\Pages\Page;
use App\Models\Pages\Row;
use App\Models\Pages\Section;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    /**
     * Display page.
     */
    public function showPageItem(Request $request)
    {
        $menuitem = MenuItem::where('url', $request->url)->first();
        if (!$menuitem)
            return $this->responseFail(trans('frontend.global.phrases.no_menuitempage'));
        $page = Page::where('id', $menuitem->page_id)->with('sections.rows.columns.components.componenttype')->first();
        return $this->responseDataSuccess(['page' => $page], trans('frontend.global.phrases.record_show'));
    }

    ############ SECTIONS ##############
    public function showSection(Page $page, Section $section)
    {
        $model = Section::where('id', $section->id)->with(['rows.columns', 'rows' => function (Builder $query) {
            $query->select('id', 'order', 'section_id')->orderBy('order', 'asc');
        }])->first();
        return $this->responseDataSuccess(['model' => $model]);
    }

    public function storeSection(Request $request, Page $page)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:sections',
            'classes' => 'nullable',
            'order' => 'required|integer',
        ]);
        $data['name'] = strtolower($data['name']);
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
            'classes' => 'nullable',
            'order' => 'required|integer',
            'name' => [
                'required',
                'string',
                Rule::unique('sections', 'name')->ignore($section->id),
            ],
        ]);
        $edititem = $section->update($data);

        if ($edititem) {
            return $this->responseUpdateSuccess(['record' => $section]);
        } else {
            return $this->responseUpdateFail();
        }
    }

    public function deleteSection(Page $page, Section $section)
    {
        $name = $section->name;
        $this->authorize('delete_page');
        $section->delete();
        return $this->responseDeleteSuccess(['name' => $name]);
    }

    ###### ROWS and COLUMS ######
    public function updateRows(Request $request, Section $section)
    {
        try {
            $rows = $request->rows;
            if (isset($rows)) {
                // Obtener los IDs de la consulta y los id de la base de datos y compara
                $currentRowIds = $section->rows->pluck('id')->toArray();
                $rowIdsFromRequest = array_column($rows, 'id');
                //Elimina filas borradas
                $rowsToDelete = array_diff($currentRowIds, $rowIdsFromRequest);
                Row::destroy($rowsToDelete);

                foreach ($rows as $row) {
                    // Usamos updateOrCreate para verificar si existe el registro y actualizarlo o insertarlo
                    $rowid = Row::updateOrCreate(
                        ['id' => $row['id'], 'section_id' => $row['section_id']],  // Verifica la existencia por 'id' y 'section_id'
                        ['order' => $row['order'], 'updated_at' => now()]  // Actualiza el campo 'order' y 'updated_at'
                    );

                    //TODO: En vez de borrar todas las columnas, solo borrar las eliminadas y actualizar o crear desde el front
                    if (isset($row['columns']) && $row['columns']) {

                        $allColumnRows = Column::where('row_id', $rowid->id)->pluck('id')->toArray();
                        $columnsIds = array_column($row['columns'], 'id');
                        $columnsToDelete = array_diff($allColumnRows, $columnsIds);
                        //Delete columns
                        Column::whereIn('id', $columnsToDelete)->delete();

                        //Agregar columnas a row
                        foreach ($row['columns'] as $col) {
                            Column::updateOrCreate(
                                ['id' => $col['id']],
                                ['row_id' => $rowid->id, 'width' => $col['width'], 'order' => $col['order']]
                            );
                        }
                    }
                }
            }else{
                //Si se borran todas las filas que limpie
                $deleteAllRow = Row::where('section_id', $request->sectionid)->pluck('id')->toArray();
                Row::destroy($deleteAllRow);
            }

            $updateRows = Row::where('section_id', $section->id)->with('columns.components')->get();

            return $this->responseUpdateSuccess(['record' => $updateRows]);
        } catch (\Exception $e) {
            return $this->responseUpdateFail(['error' => $e->getTrace()]);
        }
    }

    public function getColumnData(Column $column)
    {
        $model = Column::where('id', $column->id)->with('components.componenttype')->first();
        return $this->responseDataSuccess(['column' => $model]);
    }

    ###### COMPONENTS ######

    public function addComponentToColumn(StoreComponentRequest $request, Column $column)
    {
        #guardar componente
        $contents = [];
        $data = $request->validated();

        $data['component_type_id'] = $data['component_type_id']['id'];

        for ($i = 0; $i < $request->number_content['id']; $i++) {
            $contents[] = ['type' => 'text', 'text' => 'ipsum quia dolor sit amet', 'img' => ''];
        }
        $data['contents'] = $contents;
        $data['column_id'] = $column->id;
        $component = Component::create($data);
        if ($component) {
            return $this->responseStoreSuccess(['record' => $column]);
        } else {
            return $this->responseStoreFail();
        }
    }

    public function saveComponentContent(Request $request, Column $column)
    {
        foreach ($request->components as $k => $v) {
            //$comp =  Component::find($v->id);
            $component = Component::updateOrCreate(
                ['id' => $v['id'], 'column_id' => $column->id],
                ['contents' => $v['contents']]
            );
        }

        if ($component) {
            return $this->responseStoreSuccess(['record' => $column]);
        } else {
            return $this->responseStoreFail();
        }
    }
}
