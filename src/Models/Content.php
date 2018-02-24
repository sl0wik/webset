<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    /**
     * Relation with childrens.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrens()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * Get index page.
     *
     * @return Sl0wik\Webset\Models\Content
     */
    public static function indexPage()
    {
        return self::orderBy('position', 'asc')->first();
    }

    /**
     * Relationship with website.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    /**
     * Relation with slides.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function slides()
    {
        return $this->hasMany(ContentSlide::class);
    }
}
