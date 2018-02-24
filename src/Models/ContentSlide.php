<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentSlide extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'heading',
        'description',
        'custom',
        'href',
        'button_1_label',
        'button_1_href',
        'button_1_style',
        'button_2_label',
        'button_2_href',
        'button_2_style',
        'image_id',
        'position',
        'content_id',
    ];

    /**
     * Casted variables.
     *
     * @var array
     */
    protected $casts = [
         'custom' => 'object',
    ];

    /**
     * Relationship with content.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Relation with image.
     *
     * @return Image
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
