<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use TCG\Voyager\Contracts\User;
use TCG\Voyager\Traits\Seedable;

class DatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

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
        ]);
        $this->seed(VoyagerDatabaseSeeder::class);
        $this->seed(UsersTableSeeder::class);
    }
}
