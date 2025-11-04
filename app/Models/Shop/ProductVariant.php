<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProductVariant extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'title',
        'sku',
        'price',
        'compare_price',
        'currency',
        'stock',
        'is_active',
        'is_default',
        'specs',
        'color',
        'size'
    ];

    protected $casts = [
        'specs' => 'array',
        'price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
