<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Setting extends Model
{
    use HasFactory, SoftDeletes;
    use Filterable, Searchable;

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
        'currency_id'
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
}
