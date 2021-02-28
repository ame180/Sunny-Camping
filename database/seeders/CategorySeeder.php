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
            ['name' => 'Osoby', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Plac', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Prąd', 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
