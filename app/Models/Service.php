<?php

namespace App\Models;

use App\Models\Pages\ComponentType;
use App\Models\Pages\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Service extends Model implements HasMedia
{
    use SoftDeletes, Filterable, Searchable, InteractsWithMedia;

    protected $table = 'services';

    protected $fillable = ['icon_color_class', 'component_type_id', 'icon', 'title', 'content', 'description', 'link', 'page_id', 'link_color_class'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'img'
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->clearMediaCollection('serviceimg'); // Elimina los medios asociados
        });
    }

    /*
    * Get image's component
    */
    public function getImgAttribute()
    {
        $img = $this->getMedia('serviceimg');
        if ($img && count($img)) {
            return $img->map(function ($item) {
                return $item->getFullUrl();
            });
        }

        return [];
    }

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
