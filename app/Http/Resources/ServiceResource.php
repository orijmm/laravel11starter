<?php

namespace App\Http\Resources;

use App\Models\Pages\ComponentType;
use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ServiceResource
 */
class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $componentType = ComponentType::get();
        $data = $this->resource->toArray();
        $data['component_type_id'] = Data::getSelectedLocation($componentType, $this->component_type_id);
        return $data;
    }
}
