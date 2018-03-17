<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sl0wik\Webset\Models\Image;

class ComponentPayload extends Model
{
    use SoftDeletes;

    /**
     * Json objects.
     *
     * @var array
     */
    protected $casts = [
         'payload' => 'object',
    ];

    /**
     * Relationship with component.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Relation with images
     *
     * @return type
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'parent');
    }
}
