<?php

namespace App\Http\Resources;

use App\Models\Pages\Template;
use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PageResource
 */
class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $templates = Template::get();
        $data = $this->resource->toArray();
        $data['name'] = $this->title;
        $data['template_id'] = Data::getSelectedLocation($templates, $this->template_id);
        $data['sections'] = $this->sections;
        return $data;
    }
}
