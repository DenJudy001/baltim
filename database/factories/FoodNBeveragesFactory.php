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
        $foodName = $this->faker->unique()->foodName();
        $beverageName = $this->faker->unique()->beverageName();

        $data = [
            'code' => $this->faker->regexify('[A-Z]{3,5}'),
            'name' => $this->faker->randomElement([$foodName, $beverageName]),
            'description' => $this->faker->sentence(),
            'image' => 'food_3.jpg',
            'price' => $this->faker->numberBetween(1000, 100000),
        ];

        if ($data['name'] === $foodName) {
            $data['type'] = 'Makanan';
        } else {
            $data['type'] = 'Minuman';
        }

        return $data;
    }
}
