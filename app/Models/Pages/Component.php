<?php

namespace App\Models\Pages;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Component extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, Searchable, Filterable, InteractsWithMedia;

    protected $table = 'components';

    protected $fillable = ['contents', 'component_type_id', 'column_id'];

    protected $casts = [
        'contents' => 'array',  // Convierte el campo 'data' a un array
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'img'
    ];

    /*
    * Get image's component
    */
    public function getImgAttribute()
    {
        $img = $this->getMedia('componentimg');
        if ($img && count($img)) {
            return $img->map(function ($item) {
                return $item->getFullUrl();
            });
        }

        return [];
    }

    /**
     * Get the componenttype that owns the comment.
     */
    public function componenttype(): BelongsTo
    {
        return $this->belongsTo(ComponentType::class, 'component_type_id');
    }

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
