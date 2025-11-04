<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeOption extends Model
{
    use SoftDeletes;

    protected $table = 'product_attribute_options';

    protected $fillable = ['attribute_id', 'value', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
