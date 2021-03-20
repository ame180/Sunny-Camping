<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            ['name' => 'Camping', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Domki', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pensjonat', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
