<?php

namespace Database\Seeders;

use App\Models\order_items;
use App\Models\orders;
use App\Models\products;
use App\Models\stocks;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\warehouses;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'fddwefewfdaswe@example.com',
        ]);
        products    ::factory()->count(50)->create();
        warehouses  ::factory()->count(30)->create();
        orders      ::factory()->count(50)->create();
        order_items ::factory()->count(150)->create();
        stocks      ::factory()->count(70)->create();
    }
}
