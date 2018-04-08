<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Route;

class Menu extends Model
{
    use SoftDeletes;

    /**
     * Generate menu.
     *
     * @param string      $name
     * @param string|null $languageCode
     *
     * @return array
     */
    public static function generate($name, $languageCode = null)
    {
        if (empty($languageCode)) {
            $languageCode = getCurrentLanguageCode();
        }
        $fields = ['url_path', 'id', 'parent_id', 'head_title', 'menu_title', 'website_id', 'status'];
        $content = self::where('name', $name)
            ->where('website_id', env('WEBSITE_ID'))
            ->with('contents')
            ->first()
            ->contents()
            ->where('language_code', $languageCode)
            ->active()
            ->with([
                'website:id,url',
                'childrens:'.implode(',', $fields),
                'childrens.childrens:'.implode(',', $fields),
            ])
            ->get($fields)
            ->map(function ($content) {
                return $content;
            });

        // Hack to show only active contents. Should be resolved using with(), but didnt work while using childrens:fields and where().
        $content->flatMap(function ($content) {
            $content->childrens = $content->childrens->filter(function ($children) {
                return $children->status == 'active';
            });

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
    public function contents()
    {
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
