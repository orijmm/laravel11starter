<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionExclusion extends Model
{
    use SoftDeletes;

    protected $table = 'promotion_exclusions';

    protected $fillable = ['promotion_id', 'target_type', 'target_id'];
}
