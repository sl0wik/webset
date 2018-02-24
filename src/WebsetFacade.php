<?php

namespace Sl0wik\Webset;

use Illuminate\Support\Facades\Facade;

class WebsetFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Sl0wik\Webset\Models\Menu';
    }
}
