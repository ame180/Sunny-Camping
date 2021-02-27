<?php /** @noinspection PhpUndefinedMethodInspection */

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::factory()
            ->count(45)
            ->hasClientItems(rand(1,3))
            ->create();
    }
}
