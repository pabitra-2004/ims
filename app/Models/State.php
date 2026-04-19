<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $guarded = [];

    /**
     * Scope a query to search state by name.
     */
    #[Scope]
    protected function search(Builder $query, $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->whereLike('name', "%{$search}%")
            ->orWhereLike('lgd_code', "%{$search}%")
            ->orWhereLike('state_ut', "%{$search}%");

    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
