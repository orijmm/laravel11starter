<?php

namespace App\Services\Setting;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Services\Media\MediaService;

class SettingService
{

    /**
     * The service instance
     *
     * @var MediaService
     */
    protected $mediaService;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Get a single resource from the database
     *
     *
     * @return SettingResource
     */
    public function get(Setting $setting)
    {
        try {
            return new SettingResource($setting);
        } catch (\Throwable $th) {
            throw $th;
        }
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
     * Update logo for the specified resource
     *
     *
     * @return bool
     */
    public function updateLogo(Setting $setting, array $data)
    {
        if (isset($data['logo_url']) && $data['logo_url']) {
            $this->mediaService->replace($data['logo_url'], $setting, 'logo_url');
        }

        if (isset($data['logo_url2']) && $data['logo_url2']) {
            $this->mediaService->replace($data['logo_url2'], $setting, 'logo_url2');
        }
        if (! empty($data)) {
            return $setting->update($data);
        } else {
            return false;
        }
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
