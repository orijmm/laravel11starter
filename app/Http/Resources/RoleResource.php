<?php

namespace App\Http\Resources;

use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $data = $this->resource->toArray();
        //obtener las abilidades y formatear en id/name
        $data['abilities'] = Data::formatCollectionForSelect($this->getAbilities());

        return $data;
    }
}
