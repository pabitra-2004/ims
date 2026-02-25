<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category_ids = Category::pluck('id')->toArray();
        $name = $this->faker->unique()->words(2, true);

        return [
            'category_id' => $this->faker->randomElement($category_ids),
            'code' => strtoupper(Str::random(6)),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(75),
        ];
    }
}
