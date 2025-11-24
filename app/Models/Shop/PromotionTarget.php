<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionTarget extends Model
{
    use SoftDeletes;

    protected $table = 'promotion_targets';

    protected $fillable = ['promotion_id', 'target_type', 'target_id'];

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}
    