<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\District;
use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id ?? Customer::factory(),
            'state_id' => 36,
            'district_id' => function (array $attributes) {
                return District::whereStateId($attributes['state_id'])->inRandomOrder()->first()->id;
            },
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'pin_code' => $this->faker->postcode(),
        ];
    }
}
