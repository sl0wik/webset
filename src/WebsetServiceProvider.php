<?php

namespace Sl0wik\Webset;

use Illuminate\Support\ServiceProvider;

class ImageEditorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * Setup configuration.
     */
    protected function setupConfig()
    {
        // @TODO
    }
}