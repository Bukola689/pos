<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_name' => $this->faker->name,
            'company_address' => $this->faker->name,
            'company_phone' => $this->faker->numberBetween(1000000000, 9999999999),
            'company_email' => $this->faker->email,
            'company_fax' => $this->faker->numberBetween(1100000, 99999999),
        ];
    }
}
