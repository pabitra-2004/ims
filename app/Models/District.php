<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    protected $guarded = [];

    public function State(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }
}
