<?php

namespace App\Http\Resources;

use App\Models\World\City;
use App\Models\World\Country;
use App\Models\World\Currency;
use App\Models\World\Language;
use App\Models\World\State;
use App\Models\World\Timezone;
use App\Utilities\Data;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

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
        try {
            $languages = Language::where('code', $this->locale)->first();
            $timezones = Timezone::where('name', $this->timezone)->first();
        

            $data = $this->resource->toArray();
            $data['locale'] = ['id' => $languages->code, 'name' => $languages->name];
            $data['timezone'] = ['id' => $timezones->name, 'name' => $timezones->name];
            $data['currency_id'] = Currency::find($this->currency_id);
            $data['country_id'] = Country::find($this->country_id);
            $data['state_id'] = State::find($this->state_id);
            $data['city_id'] = City::find($this->city_id);
            return $data;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
