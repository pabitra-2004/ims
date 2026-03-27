<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product_ids = Product::where('is_active', true)->distinct()->pluck('id')->toArray();
        return [
            'product_id' => $this->faker->randomElement($product_ids),
            'quantity' => $this->faker->numberBetween(5, 50),
            'reserved' => $this->faker->numberBetween(1, 20),
        ];
    }
}
