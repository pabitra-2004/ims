<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
        $name = $this->faker->unique()->words(2, true);

        return [        
            'code' => $this->faker->unique()->regexify('[A-Z]{3}-[A-Z]{3}-' . now()->year .'-[0-9]{3}'), // category-productName-year-number       
            'name' => ucwords($name),         
            'description' => $this->faker->optional()->sentence(),
        ];
    }
}
