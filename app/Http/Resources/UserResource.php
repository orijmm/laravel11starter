<?php

namespace App\Http\Resources;

use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {

        $data = $this->resource->toArray();
        $data['is_admin'] = $this->is_admin;
        $data['is_owner'] = \Auth::check() && \Auth::user()->id === $this->id;
        $data['abilities'] = $this->getAbilities();
        $data['created_at'] = ! empty($this->resource->created_at) ? $this->resource->created_at->diffForHumans() : null;
        $data['updated_at'] = ! empty($this->resource->updated_at) ? $this->resource->updated_at->diffForHumans() : null;
        $data['roles'] = Data::formatRoleCollectionForSelect($this->roles, 'name', 'name');
        if (isset($data['avatar'])) {
            unset($data['avatar']);
        }

        return $data;
    }
}
