<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use SoftDeletes;

    protected $table = 'product_attributes';

    protected $fillable = ['name', 'slug'];

    public function options(): HasMany
    {
        return $this->hasMany(ProductAttributeOption::class, 'attribute_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_attribute_product')
            ->withPivot('product_attribute_option_id')
            ->withTimestamps();
    }
}
