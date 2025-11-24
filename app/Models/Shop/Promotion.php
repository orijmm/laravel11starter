<?php

namespace App\Models\Shop;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes, Searchable, Filterable;

    protected $table = 'promotions';

    protected $fillable = [
        'title',
        'type',
        'value',
        'start_at',
        'end_at',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function targets()
    {
        return $this->hasMany(PromotionTarget::class);
    }

    public function exclusions()
    {
        return $this->hasMany(PromotionExclusion::class);
    }
}
