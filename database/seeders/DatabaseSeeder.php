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
            ClientSeeder::class,
            ServiceCategorySeeder::class,
            ItemSeeder::class,
            ServiceSeeder::class,
            UsersTableSeeder::class,
        ]);
    }
}
