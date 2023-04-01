<?php

namespace Database\Factories;

use FakerRestaurant\Provider\id_ID\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FoodNBeverages>
 */
class FoodNBeveragesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Restaurant($this->faker));
        return [
            'name' =>  $this->faker->foodName(),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['Makanan', 'Minuman']),
            'price' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
