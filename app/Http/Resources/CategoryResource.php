<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CategoryResource
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $data = $this->resource->toArray();
        $data['parent'] = $this->whenLoaded('parent', function () {
            return [
                'id'   => $this->parent->id,
                'name' => $this->parent->name,
                'slug' => $this->parent->slug,
            ];
        });
        $data['children'] = CategoryResource::collection(
            $this->whenLoaded('children')
        );

        $data['created_at'] = $this->created_at?->toDateTimeString();
        $data['updated_at'] = $this->updated_at?->toDateTimeString();
        
        return $data;
    }
}
