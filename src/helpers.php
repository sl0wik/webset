<?php

/**
 * Returning translated (lozalized) url.
 *
 * @param string $url url for example /guides/{name}
 * @param string|null $attributes For example ['name' => 'Brazil']
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
 * Based on mcamara/laravel-localization function LaravelLocalization::getCurrentLocale()
 *
 * @return string
 */
function getCurrentLanguageCode()
{
    return LaravelLocalization::getCurrentLocale();
}
