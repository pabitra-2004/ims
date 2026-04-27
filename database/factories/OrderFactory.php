<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subTotal = $this->faker->numberBetween(1000, 15000);
        $discount = $this->faker->optional()->numberBetween(0, 50);
        $additionalCharges = $this->faker->optional()->numberBetween(7, 50);

        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,        
            'code' => Str::random(10),       
            'date' => $this->faker->date(),
            'sub_total' => $subTotal,
            'discount' => $discount,
            'additional_charges' => $additionalCharges,
            'total' => $subTotal - ($discount ?? 0) + ($additionalCharges ?? 0),

            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
