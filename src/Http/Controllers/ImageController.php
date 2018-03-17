<?php

namespace Sl0wik\Webset\Http\Controllers;

use Sl0wik\Webset\Models\Image;

class ImageController extends Controller
{
    /**
     * Show image for public access.
     *
     * @param string $hash
     * @param string $size
     *
     * @return Illuminate\Http\Response
     */
    public function showByHash($hash, $size = null)
    {
        $image = Image::where('hash', $hash)->firstOrFail();
        if ($size) {
            return $image->size($size)->response();
        }

        return $image->response();
    }
}
