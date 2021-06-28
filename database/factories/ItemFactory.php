<?php

namespace Database\Factories;

class ItemFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [
            'service_category_id' => 0,
            'name' => 'Item Name',
            'price' => $this->faker->numberBetween(2, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
