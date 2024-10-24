<?php

namespace App\Models\Pages;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'components';

    protected $fillable = ['content', 'name', 'description', 'order', 'component_type_id'];

    /**
     * Get the componenttype that owns the comment.
     */
    public function componenttype(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function column()
    {
        return $this->belongsToMany(Column::class);
    }
}
