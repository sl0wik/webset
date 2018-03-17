<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Component extends Model
{
    use SoftDeletes;

    /**
     * Json objects.
     *
     * @var array
     */
    protected $casts = [
         'custom' => 'object',
    ];

    /**
     * Get custom values.
     *
     * @param string $key
     *
     * @return string|null
     */
    public function custom($key)
    {
        if (isset($this->custom->$key)) {
            return $this->custom->$key;
        }
    }
}
