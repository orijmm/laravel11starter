<?php

namespace App\Models\Pages;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use HasFactory, SoftDeletes, Searchable, Filterable;

    protected $table = 'components';

    protected $fillable = ['content', 'name', 'description', 'component_type_id', 'filename'];

    /**
     * Get the componenttype that owns the comment.
     */
    public function componenttype(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class, 'component_type_id');
    }

    public function column()
    {
        return $this->belongsToMany(Column::class);
    }
}
