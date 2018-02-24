<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Sl0wik\LaravelImageEditor\Traits\ImageCache;
use Sl0wik\LaravelImageEditor\Traits\ImageEditor;

class Image extends Model
{
    use ImageEditor, ImageCache, SoftDeletes;

    /**
     * Get original image file.
     *
     * @return string
     */
    public function getOriginalImageFile()
    {
        return Storage::disk($this->disk)->get($this->path);
    }

    /**
     * Generate image hash.
     *
     * @return string
     */
    public function generateHash()
    {
        return md5($this->getOriginalImageFile());
    }

    /**
     * Generate cache id.
     *
     * @return string
     */
    public function getCacheID()
    {
        return 'images/'.$this->id;
    }

    /**
     * Generate url to image.
     *
     * @return string
     */
    public function getHrefAttribute()
    {
        return $this->href();
    }

    /**
     * Generate url to image.
     *
     * @return string
     */
    public function href()
    {
        $href = '/images/'.$this->hash.'/'.$this->size();

        return url($href);
    }

    /**
     * Relation with image parent.
     *
     * @return type
     */
    public function parent()
    {
        return $this->morphTo();
    }
}
