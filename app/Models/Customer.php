<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * Scope a query to search categoties by name.
     */
    #[Scope]
    protected function search(Builder $query, string $search): void
    {
        $query->whereLike('name', "%{$search}%");
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
