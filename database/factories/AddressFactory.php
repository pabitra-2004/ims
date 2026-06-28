<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\District;
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
        $stateId = 36;
        $districtId = District::whereStateId($stateId)->inRandomOrder()->value('id');

        return [
            'customer_id' => Customer::inRandomOrder()->value('id') ?? Customer::factory(),
            'state_id' => $stateId,
            'district_id' => $districtId,
            'city' => $this->faker->city(),
            'address' => $this->faker->address(),
            'pin_code' => $this->faker->postcode(),
        ];
    }
}
