<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
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
            'description' => $this->faker->sentence,
            'category_id' => Category::all()->random()->id,
            'price' => $this->faker->numberBetween(1000, 10000),
            'quantity' => $this->faker->numberBetween(1, 10),
            'discount' => $this->faker->numberBetween(10, 50),
            'alert_stock' => $this->faker->numberBetween(10, 100),
        ];
    }
}
