<?php

namespace App\Http\Resources;

use App\Utilities\Data;
use Illuminate\Http\Resources\Json\JsonResource;
use Nnjeim\World\World;

/**
 * Class SettingResource
 */
class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        $languages = World::languages();
        $timezones = World::timezones();
        $currencies = World::currencies();
        $countries = World::countries();
        $states = World::states();
        $cities = World::cities();

        $data = $this->resource->toArray();
        $data['locale'] = Data::getSelectedLocation($languages->data, $this->locale, 'code', 'name_native');
        $data['timezone'] = Data::getSelectedLocation($timezones->data, $this->timezone, 'name', 'name');
        $data['currency_id'] = Data::getSelectedLocation($currencies->data, $this->currency_id);
        $data['country_id'] = Data::getSelectedLocation($countries->data, $this->country_id);
        $data['state_id'] = Data::getSelectedLocation($states->data, $this->state_id);
        $data['city_id'] = Data::getSelectedLocation($cities->data, $this->city_id);
        return $data;
    }
}
