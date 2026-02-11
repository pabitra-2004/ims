<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
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
     * Scope a query to search categoties by name.
     */
    #[Scope]
    protected function search(Builder $query, $search): void
    {
        $query->whereLike('name', "%{$search}%");
    }

    #[Scope]
    protected function filter(Builder $query, $filters): void
    {
        if ($filters) {
            $query->whereIn('is_active', array_map(
                fn($item) => $item === 'active' ? true : false,
                $filters
            ));
        }
    }
}
