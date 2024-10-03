<?php

namespace App\Services\Role;

use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleSearchResource;
use App\Models\Role;
use App\Models\User;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use App\Traits\Filterable;
use App\Utilities\Data;

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
        if (! empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (! empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (! empty($data['sort_by']) && ! empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return RoleResource::collection($query->paginate(10));
    }

    /**
     * Get a single resource from the database
     *
     *
     * @return RoleResource
     */
    public function get(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Get resource index from the database
     *
     * @param  $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search($data)
    {
        $query = Role::query();
        $per_page = isset($data['per_page']) && is_numeric($data['per_page']) ? intval($data['per_page']) : 10;

        if (! empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (! empty($data['sort_by']) && ! empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return RoleSearchResource::collection($query->paginate($per_page));
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
        //nombre del rol en minusculas
        $data['name'] = strtolower($data['name']);
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
        //nombre del rol en minusculas
        $data['name'] = strtolower($data['name']);
        $abilities = Data::take($data, 'abilities');

        if (! empty($abilities)) {
            Bouncer::sync($role)->abilities($abilities);
        }

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
     * Asign permission to role
     *
     *
     * @return Builder|Model|null
     *
     */
    public function assignAbility(Role $role, array $data)
    {
        $data = $this->clean($data);

        //se agrega la habilidad al rol
        $ability = Bouncer::ability()->where('name', $data['name'])->first();

        if ($ability) {
            // Si la habilidad ya existe, la asignamos al rol
            $record = Bouncer::allow($role->name)->to($ability, Role::class);

            return $record;
        } else {
            abort(404, 'La habilidad no existe');
        }

        
    }

    /**
     * Asign permission to role
     *
     *
     * @return Builder|Model|null
     *
     */
    public function createAbility($data)
    {
        $ability = Bouncer::ability()->firstOrCreate([
            'name' => $data['name'],
            'title' => $data['title'],
        ]);

        if (! empty($ability)) {
            return $ability;
        } else {
            return null;
        }
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

    /**
     * Filter resources
     *
     * @return void
     */
    private function filter(Builder &$query, $filters)
    {
        $query->filter(Arr::except($filters, ['role']));

        if (! empty($filters['role'])) {
            $roleFilter = Filterable::parseFilter($filters['role']);
            if (! empty($roleFilter)) {
                if (is_array($roleFilter[2])) {
                    $query->whereIs(...$roleFilter[2]);
                } else {
                    $query->whereIs($roleFilter[2]);
                }
            }
        }
    }
}
