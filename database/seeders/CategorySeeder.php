<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Osoby', 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Plac', 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prąd', 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
