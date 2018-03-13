<?php

namespace Sl0wik\Webset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComponentPayload extends Model
{
    use SoftDeletes;

    /**
     * Json objects.
     *
     * @var array
     */
    protected $casts = [
         'payload' => 'object',
    ];

    /**
     * Relationship with component.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
