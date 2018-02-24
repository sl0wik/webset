<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use SoftDeletes;

    /**
     * Json objects
     *
     * @var array
     */
    protected $casts = [
         'custom' => 'object',
    ];
}
