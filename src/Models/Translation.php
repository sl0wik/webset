<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    /**
     * Get cached translations for current website.
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getCached()
    {
        $class = self::class;
        $websiteId = env('WEBSITE_ID');
        $key = "{$class}.websiteId:{$websiteId}";
        if (Cache::has($key)) {
            $cached = Cache::get($key);
        } else {
            $cached = self::where($websiteId)->get();
            Cache::put($class, $cached, config('cache.translations.lifetime', 10));
        }

        return $cached;
    }
}
