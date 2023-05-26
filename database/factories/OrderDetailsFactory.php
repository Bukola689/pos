<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::all()->random()->id,
            'product_id' => Product::all()->random()->id,
            'quantity' => $this->faker->numberBetween(10, 100),
            'unitprice' => $this->faker->numberBetween(1000, 10000),
            'amount' => $this->faker->numberBetween(10, 100),
            'discount' => '10',
        ];
    }
}
