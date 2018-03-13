<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use SoftDeletes;

    /**
     * Casted variables.
     *
     * @var array
     */
    protected $casts = [
         'has_childrens'            => 'boolean',
         'custom'                   => 'object',
         'content_template_payload' => 'object',
    ];

    /**
     * Relation with childrens.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrens()
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('position', 'ASC');
    }

    /**
     * Relation with parent.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    /**
     * Get index page.
     *
     * @return Sl0wik\Webset\Models\Content
     */
    public static function indexPage()
    {
        return self::orderBy('position', 'ASC')->first();
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

    /**
     * Scope a query to active contents.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get href.
     *
     * @return string
     */
    public function getHrefAttribute()
    {
        return localize_url($this->url_path);
    }

    /**
     * Relationship with content template.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contentTemplate()
    {
        return $this->belongsTo(ContentTemplate::class);
    }

    /**
     * Relation with component payloads.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function componentPayloads()
    {
        return $this->hasMany(ComponentPayload::class);
    }

    /**
     * Get components.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getComponents($name = null)
    {
        $query = $this->componentPayloads();
        if ($name) {
            $query->whereHas('component', function ($query) use ($name) {
                $query->where('name', $name);
            });
        }

        return $query->get()->map(function ($component) {
            return $component->payload;
        });
    }
}
