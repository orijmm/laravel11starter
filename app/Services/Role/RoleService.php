<?php

namespace App\Services\Role;

use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleService
{
    /**
     * Get resource index from the database
     *
     * @param  $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($data)
    {
        $query = Role::query();
        $per_page = isset($data['per_page']) && is_numeric($data['per_page']) ? intval($data['per_page']) : 10;

        if (! empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (! empty($data['sort_by']) && ! empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return RoleResource::collection($query->paginate($per_page));
    }

    /**
     * Creates resource in the database
     *
     *
     * @return Builder|Model|null
     *
     */
    public function create(array $data)
    {
        $data = $this->clean($data);

        $record = Role::query()->create($data);
        if (! empty($record)) {
            return $record->fresh();
        } else {
            return null;
        }
    }

    /**
     * Updates resource in the database
     *
     *
     * @return bool
     *
     */
    public function update(Role $role, array $data)
    {
        $data = $this->clean($data);

        return $role->update($data);
    }

    /**
     * Deletes resource in the database
     *
     * @param  Role|Model  $role
     * @return bool
     */
    public function delete(Role $role)
    {
        return $role->delete();
    }

    /**
     * Clean the data
     *
     *
     * @return array
     */
    private function clean(array $data)
    {
        foreach ($data as $i => $row) {
            if ($row === 'null') {
                $data[$i] = null;
            }
        }

        return $data;
    }
}
