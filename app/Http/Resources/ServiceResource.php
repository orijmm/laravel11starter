<?php

namespace App\Http\Resources;

use App\Models\Pages\ComponentType;
use App\Models\Pages\Page;
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
        $allpages = Page::select('title as name', 'id')->get();
        $data = $this->resource->toArray();
        $data['component_type_id'] = Data::getSelectedLocation($componentType, $this->component_type_id);
        $data['page_id'] = Data::getSelectedLocation($allpages, $this->page_id, 'id', 'title');
        return $data;
    }
}
