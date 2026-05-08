<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
            'images' => 'array',
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
    protected function filter(Builder $query, array $filters)
    {
        if ($filters['status']) {
            $query->whereIn('is_active', array_map(fn($item) => $item === 'active' ? true : false, $filters['status']));
        }

        if ($filters['categories']) {
            $query->whereIn('category_id', $filters['categories']);
        }
    }
    // #[Scope]
    // protected function categorySearch(Builder $query, $searchCategories){
    //     if ($searchCategories) {
    //         $query->whereLike('name', "%{$searchCategories}%");
    //     }
    // }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
}
