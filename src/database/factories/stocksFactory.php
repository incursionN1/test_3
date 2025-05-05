<?php

namespace Database\Factories;

use App\Models\products;
use App\Models\warehouses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\stocks>
 */
class StocksFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_id'  => warehouses::pluck('id')->random(),
            'product_id'    => products::pluck('id')->random(),
            'stock'         => $this->faker->numberBetween(0, 1000),
        ];
    }
}
