<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Project extends Model implements HasMedia
{
    use SoftDeletes, Filterable, Searchable, InteractsWithMedia;

    protected $table = 'projects';

    protected $fillable = ['img_alt', 'category', 'title', 'description'];

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
            $model->clearMediaCollection('projectimg'); // Elimina los medios asociados
        });
    }

    /*
    * Get image's component
    */
    public function getImgAttribute()
    {
        $img = $this->getMedia('projectimg');
        if ($img && count($img)) {
            return $img->map(function ($item) {
                return $item->getFullUrl();
            });
        }

        return [];
    }
}
