<?php

namespace Sl0wik\Webset\Models;

use Sl0wik\Webset\Models\Content;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Route;

class Menu extends Model
{
    use SoftDeletes;

    /**
     * Generate menu.
     *
     * @param string $name
     * @return array
     */
    public static function generate($name)
    {
        $fields = ['url_path', 'id', 'parent_id', 'head_title', 'menu_title', 'website_id'];

    	$content = Menu::where('name', $name)
            ->with('contents')
            ->first()
            ->contents()
            ->with([
                'website:id,url',
                'childrens:'.implode(',', $fields),
                'childrens.childrens:'.implode(',', $fields),
            ])
            ->get($fields)
            ->map(function ($content) {
                return $content;
            });

    	return $content;
    }

    /**
     * Generate routes.
     *
     * @return void
     */
    public function routes()
    {
        Route::get('/', '\Sl0wik\Webset\Http\Controllers\ContentController@index');

        Content::each(function ($content) {
            Route::get($content->url_path, '\Sl0wik\Webset\Http\Controllers\ContentController@showBySlug');
        });
    }

    /**
     * Get builder with query of languages used in Content.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public static function languages()
    {
        $languageCodes = Content::distinct('language_code')
                                ->get(['language_code'])
                                ->pluck('language_code')
                                ->toArray();
        return Language::whereIn('code', $languageCodes);
    }

    /**
     * Get collection of languages used in content.
     *
     * @return Illuminate\Support\Collection
     */
    public function getLanguages()
    {
        return $this->languages()->get();
    }

    /**
     * Relation with contents.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contents () {
        return $this->belongsToMany(Content::class);
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
}
