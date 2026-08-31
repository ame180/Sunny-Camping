<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    protected $seedersPath = __DIR__ . '/';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            ServiceSeeder::class,
            ServiceCategorySeeder::class,
            ItemSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
