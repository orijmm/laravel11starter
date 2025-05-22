<?php

namespace App\Models;

use App\Models\Pages\ComponentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Filterable;
use App\Traits\Searchable;

class Service extends Model
{
    use SoftDeletes, Filterable, Searchable;

    protected $table = 'services';

    protected $fillable = ['icon_color_class', 'component_type_id', 'icon', 'title', 'description', 'link', 'link_color_class'];

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }
}
