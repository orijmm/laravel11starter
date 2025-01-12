<?php

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Traits\Filterable;

if (!function_exists('responseMetaLinks')) {
    function responseMetaLinks($query, $numPages)
    {
        try {
            $jsonResource = new JsonResource($query);
            return $jsonResource->collection($query->paginate($numPages));
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }
}

if (!function_exists('responseJsonGet')) {
    function responseJsonGet($query)
    {
        try {
            $jsonResource = new JsonResource($query);
            return $jsonResource->collection($query);
        } catch (\Exception $e) {
            return response()->json(['Error' => $e->getMessage()]);
        }
    }
}

if (!function_exists('filter')) {
    function filter(Builder &$query, $filters)
    {
        $query->filter($filters);
    }
}

/*
* Filtro de array de objetos segun busqueda
* Argumentos: Array de objetos ($arrObj), termino de busqueda ($search), atributo del objeto a buscar ($field)
*/
if (!function_exists('filterArrObj')) {
    function filterArrObj($arrObj, $search, $field)
    {
        return collect($arrObj)->filter(function ($item) use($search, $field) {
            return str_contains(strtolower($item[$field]), strtolower($search));
        })->values();
    }
}

/*
* Filtro de array de objetos segun busqueda
* Argumentos: Array de objetos ($arrObj), termino de busqueda ($search), atributo del objeto a buscar ($field)
*/
if (!function_exists('filterArr')) {
    function filterArr($arr, $search)
    {
        return array_filter($arr, function ($item) use ($search) {
            return str_contains(strtolower($item), strtolower($search));
        });
    }
}
