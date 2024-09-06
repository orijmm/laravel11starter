<?php

namespace App\Services\Setting;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\Filterable;
use App\Utilities\Data;
use Bouncer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class SettingService
{

    /**
     * Get a single resource from the database
     *
     *
     * @return SettingResource
     */
    public function get(Setting $setting)
    {
        return new SettingResource($setting);
    }

    /**
     * Get resource index from the database
     *
     * @param  $query
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($data)
    {
        $query = Setting::query();
        if (! empty($data['search'])) {
            $query = $query->search($data['search']);
        }
        if (! empty($data['filters'])) {
            $this->filter($query, $data['filters']);
        }
        if (! empty($data['sort_by']) && ! empty($data['sort'])) {
            $query = $query->orderBy($data['sort_by'], $data['sort']);
        }

        return SettingResource::collection($query->paginate(10));
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

        $record = Setting::query()->create($data);
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
    public function update(Setting $setting, array $data)
    {
        $data = $this->clean($data);

        return $setting->update($data);
    }

    /**
     * Deletes resource in the database
     *
     * @param  Setting|Model  $setting
     * @return bool
     */
    public function delete(Setting $setting)
    {
        return $setting->delete();
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
