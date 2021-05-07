<?php

namespace Database\Factories;

use App\Models\ClientItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => 0,
            'service_category_id' => 0,
            'client_id' => 0,
            'name' => $this->faker->safeColorName,
            'price' => $this->faker->numberBetween(2, 20),
            'count' => $this->faker->numberBetween(1, 4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
