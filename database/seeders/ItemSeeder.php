<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory()->createMany([
            ['service_category_id' => 1, 'name' => 'Dorosły', 'price' => 18],
            ['service_category_id' => 1, 'name' => 'Dziecko', 'price' => 14],
            ['service_category_id' => 2, 'name' => 'Duży', 'price' => 6],
            ['service_category_id' => 2, 'name' => 'Mały', 'price' => 4],
            ['service_category_id' => 3, 'name' => 'Prąd', 'price' => 10],
        ]);
    }
}
