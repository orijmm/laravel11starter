<?php

namespace App\Models\Shop;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use SoftDeletes,
        InteractsWithMedia, Searchable, Filterable;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'brand',
        'model',
        'is_featured',
        'is_active',
        'has_stock',
        'is_on_sale',
        'sale_percentage',
        'rating_avg',
        'rating_count',
        'metadata'
    ];

    protected $casts = ['metadata' => 'array', 'is_featured' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_attribute_product')
            ->withPivot('product_attribute_option_id')
            ->withTimestamps();
    }
}
