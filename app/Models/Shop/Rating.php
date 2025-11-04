<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $table = 'ratings';

    protected $fillable = ['user_id', 'product_id', 'variant_id', 'rating', 'comment'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
