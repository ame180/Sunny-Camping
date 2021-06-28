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
            ['service_category_id' => 1, 'name' => 'Dziecko', 'price' => 15],
            ['service_category_id' => 2, 'name' => 'Klimatyczne', 'price' => 2],
            ['service_category_id' => 3, 'name' => 'Duży', 'price' => 7],
            ['service_category_id' => 3, 'name' => 'Mały', 'price' => 5],
            ['service_category_id' => 4, 'name' => 'Prąd', 'price' => 12],
        ]);
    }
}
