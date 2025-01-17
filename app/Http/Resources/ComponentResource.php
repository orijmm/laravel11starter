<?php

namespace App\Http\Resources;

use App\Models\Pages\ComponentType;
use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ComponentResource
 */
class ComponentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $componenttype = ComponentType::get();
        $data = $this->resource->toArray();
        $data['section'] = $this->resource->column->row->section;
        $data['component_type_id'] = Data::getSelectedLocation($componenttype, $this->component_type_id);
        return $data;
    }
}
