<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->sentence(),
            'phone' => $this->faker->numberBetween(100000000, 999999999),
            'email' => $this->faker->email
        ];
    }
}
