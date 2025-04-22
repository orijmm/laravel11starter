<?php

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;

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
        return collect($arrObj)->filter(function ($item) use ($search, $field) {
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

/*
* Obtener nombre campo de error en base de datos
* Argumentos: Illuminate\Database\QueryException $e
* Return String
*/
if (!function_exists('getQueryErrors')) {
    function getQueryErrors($e)
    {
        $queryErrors = [
            1062 => trans('frontend.global.phrases.duplicate_entry'),
            1451 => trans('frontend.global.phrases.integrity_constraint_violation'),
            1452 => trans('frontend.global.phrases.integrity_constraint_violation'),
            1406 => trans('frontend.global.phrases.value_toolong'),
            1054 => trans('frontend.global.phrases.unknown_column')
        ];

        if(!isset($e->errorInfo[1])){
            return $e->getMessage();
        }

        if(!array_key_exists($e->errorInfo[1], $queryErrors)){
            return trans('frontend.global.phrases.error_query_general').' '.$e->getMessage();
        }

        preg_match("/Data too long for column '(.+?)'/", $e->getMessage(), $getErrorField);

        $fieldError = isset($getErrorField[1]) ? trans('frontend.users.labels.'.$getErrorField[1]) : '';

        if ($e->errorInfo[1] == 1406) {
            return $queryErrors[$e->errorInfo[1]].': '.$fieldError;
        }
        
        return trans('frontend.global.phrases.error_query_general').' '.$e->getMessage();
    }
}
