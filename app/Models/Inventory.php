<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['product'];


    #[Scope]
    protected function search(Builder $query, string $search)
    {
        if ($search) {
            $query->whereLike('code', "%{$search}%")
                ->orWhereLike('name', "%{$search}%");
        }
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
