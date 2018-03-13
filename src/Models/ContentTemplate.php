<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sl0wik\Webset\Models\Website;

class ContentTemplate extends Model
{
    use SoftDeletes;

    /**
     * Casted variables.
     *
     * @var array
     */
    protected $casts = [
        'custom' => 'object',
        'schema' => 'object',
    ];

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
