<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'components';

    protected $fillable = ['content', 'name', 'description', 'order', 'column_id', 'component_type_id', 'deleted_at'];

    /**
     * Get the componenttype that owns the comment.
     */
    public function componenttype(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }
}
