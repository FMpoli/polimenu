<?php

namespace Detit\Polimenu\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
* @property string $id
* @property string $title
* @property string $slug
* @property string $summary
* @property string $content
* @property string $links
* @property string $tags
 */
class Menu extends Model
{
    protected $table = 'polimenu_menus';
    use HasTranslations;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'handle',
        'items',
        'is_published',
    ];

    protected $translatable = [
        'items',
    ];

    protected $casts = [
        'items' => 'array'
    ];


}
