<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    protected $guarded = [];

    // protected $casts = [
    //     'date' => 'datetime',
    // ];

    #[Scope]
    public function search(Builder $query, string $search)
    {
        if ($search) {
            $query->whereLike('name', "%{ $search }%");
        }
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
