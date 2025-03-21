<?php

namespace App\Http\Resources;

use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ComponentTypeResource
 */
class ComponentTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $data = $this->resource->toArray();
        $data['filename'] = ['name' => $this->filename, 'id' => $this->filename ];
        $data['filename_name'] = $this->filename;
        return $data;
    }
}
