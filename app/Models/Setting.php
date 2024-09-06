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

    public function scopeListado($query)
    {
        // Define the listado scope
    }

    public function scopeSearch($query, $term)
    {
        // Define the search scope
    }
}
