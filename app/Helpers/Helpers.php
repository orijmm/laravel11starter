<?php

use Illuminate\Http\Resources\Json\JsonResource;

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