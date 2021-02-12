<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientFactory extends Factory
{
    use RefreshDatabase;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $arrivalDate = $this->faker->dateTimeBetween('-2 months')->format('Y-m-d');
        return [
            "first_name" => $this->faker->firstName,
            "last_name" => $this->faker->lastName,
            "arrival_date" => $arrivalDate,
            "departure_date" => $arrivalDate->add(new DateInterval('P'.rand(1, 30).'D')),
            "sector" => rand(1, 6),
            "adults" => rand(1, 5),
            "children" => rand(0,5),
            "electricity" => rand(0, 1),
            "small_places" => rand(0, 5),
            "big_places" => rand(0, 5),
            "discount" => array_rand([0, 5, 10]),
            "comment" => $this->faker->sentence(),
            "status" => 'unsettled',
            "paid" => 0,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}
