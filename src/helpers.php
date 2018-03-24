<?php

/**
 * Short function to return key from dictionary. Laravel trans() helper behing.
 *
 * @param string          $key      Key name like "dict.test".
 * @param string|null     $data     Optional parameters to trans.
 * @return string
 */
function __t($key, $data = null)
{
    if (\Lang::has($key)) {
        if ($data) {
            return trans($key, $data);
        } else {
            return trans($key);
        }
    } else {
        // TODO: we need parsing like in trans
        $translation = Sl0wik\Webset\Models\Translation::getCached();
        $item = $translation->where('language_code', \LaravelLocalization::getCurrentLocale())->where('key', $key)->first();

        if ($item) {
            return $item->value;
        } else {
            return $key;
        }
    }
}

/**
 * Returning translated (lozalized) url.
 *
 * @param string      $url        url for example /guides/{name}
 * @param string|null $attributes For example ['name' => 'Brazil']
 *
 * @return string Localized url for example /guias/Brazil
 */
function localize_url($url, $attributes = null)
{
    $prefix = request()->route()->getPrefix();
    if (is_null($prefix)) {
        $url = \LaravelLocalization::getLocalizedURL(
            false,
            $url,
            $attributes
        );
        // LaravelLocalization seems to add locale even when its set to false
        $url = str_replace(LaravelLocalization::getCurrentLocale().'/', '', $url);

        return $url;
    } else {
        return \LaravelLocalization::getLocalizedURL(
            LaravelLocalization::getCurrentLocale(),
            $url,
            $attributes
        );
    }
}

/**
 * Return current language code (locale).
 * Based on mcamara/laravel-localization function LaravelLocalization::getCurrentLocale().
 *
 * @return string
 */
function getCurrentLanguageCode()
{
    return LaravelLocalization::getCurrentLocale();
}
