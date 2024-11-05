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
