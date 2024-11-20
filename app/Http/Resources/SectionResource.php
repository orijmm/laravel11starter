<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SectionResource
 */
class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $data = $this->resource->toArray();
        // $data['sections'] = $this->sections;
        return $data;
    }
}
