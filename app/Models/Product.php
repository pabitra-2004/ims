<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $guarded = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope a query to search products by code, name and slug.
     */
    #[Scope]
    protected function search(Builder $query, $search)
    {
        if ($search) {
            $query->whereLike('code', "%{$search}%")
                ->orWhereLike('name', "%{$search}%")
                ->orWhereLike('slug', "%{$search}%");
        }
    }

    #[Scope]
    protected function statusfilter(Builder $query, $statusfilters)
    {
        if ($statusfilters) {
            $query->whereIn('is_active', array_map(fn ($item) => $item === 'active' ? true : false, $statusfilters));
        }
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
