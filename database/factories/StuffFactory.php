<?php

namespace Database\Factories;

use FakerRestaurant\Provider\id_ID\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stuff>
 */
class StuffFactory extends Factory
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
            'supplier_id' =>  mt_rand(1,20),
            'stuff_name' => $this->faker->randomElement([$this->faker->vegetableName(), $this->faker->meatName(), $this->faker->sauceName(), $this->faker->fruitName(), $this->faker->dairyName()]),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
