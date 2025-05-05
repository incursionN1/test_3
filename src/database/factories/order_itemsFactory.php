<?php

namespace Database\Factories;

use App\Models\orders;
use App\Models\products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\order_items>
 */
class order_itemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'orders_id' => orders::pluck('id')->random(),
            'product_id' => products::pluck('id')->random(),
            'count' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
