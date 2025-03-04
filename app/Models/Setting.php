<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    use HasFactory, SoftDeletes;
    use Filterable, Searchable;
    use InteractsWithMedia;


    protected $table = 'admin_settings';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_company',
        'description',
        'address',
        'phone',
        'email',
        'locale',
        'timezone',
        'state_id',
        'city_id',
        'country_id',
        'currency_id',
        'googlemaps',
        'instagram',
        'facebook',
        'twitter',
        'tiktok',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url',
        'logo_thumb_url',
    ];

    /**
     * ALlowed search fields
     *
     * @var string[]
     */
    protected $searchFields = ['name_company', 'description'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
    }

    public function setLocaleAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'id'
        if (is_array($value) && isset($value['id'])) {
            // Guarda solo el valor de 'id'
            $this->attributes['locale'] = $value['id'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['locale'] = $value;
        }
    }

    public function setTimezoneAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'name'
        if (is_array($value) && isset($value['name'])) {
            // Guarda solo el valor de 'name'
            $this->attributes['timezone'] = $value['name'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['timezone'] = $value;
        }
    }

    public function setCurrencyIdAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'id'
        if (is_array($value) && isset($value['id'])) {
            // Guarda solo el valor de 'id'
            $this->attributes['currency_id'] = $value['id'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['currency_id'] = $value;
        }
    }

    public function setCountryIdAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'id'
        if (is_array($value) && isset($value['id'])) {
            // Guarda solo el valor de 'id'
            $this->attributes['country_id'] = $value['id'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['country_id'] = $value;
        }
    }

    public function setStateIdAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'id'
        if (is_array($value) && isset($value['id'])) {
            // Guarda solo el valor de 'id'
            $this->attributes['state_id'] = $value['id'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['state_id'] = $value;
        }
    }

    public function setCityIdAttribute($value)
    {
        // Verifica si $value es un array y si contiene la clave 'id'
        if (is_array($value) && isset($value['id'])) {
            // Guarda solo el valor de 'id'
            $this->attributes['city_id'] = $value['id'];
        } else {
            // Si no es un array válido, guarda el valor tal como es
            $this->attributes['city_id'] = $value;
        }
    }

    /**
     * @return \Closure|mixed|null|Media
     */
    public function logo()
    {
        return $this->getMedia('logo')->first();
    }

    /**
     * Returns the logo url attribute
     *
     * @return string|null
     */
    public function getLogoUrlAttribute()
    {
        $logo = $this->logo();
        if ($logo) {
            return $logo->getFullUrl();
        }

        return null;
    }

    /**
     * Returns the logo url attribute
     *
     * @return string|null
     */
    public function getLogoThumbUrlAttribute()
    {
        $logo = $this->logo();
        if ($logo) {
            return $logo->getAvailableFullUrl(['small_thumb']);
        }

        return null;
    }

    /**
     * Register the conversions
     *
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('small_thumb')
            ->fit(Fit::Crop, 300, 300)
            ->nonQueued();
        $this->addMediaConversion('medium_thumb')
            ->fit(Fit::Crop, 600, 600)
            ->nonQueued();
        $this->addMediaConversion('large_thumb')
            ->fit(Fit::Crop, 1200, 1200)
            ->nonQueued();
    }
}
