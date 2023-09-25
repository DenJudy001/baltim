<?php

namespace Database\Factories;

use App\Models\Pos;
use App\Models\DetailPos;
use App\Models\FoodNBeverages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPos>
 */
class DetailPosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // static $id = 1;
        // static $id = 251;
        static $id = 256;
        // $posNumber = $this->faker->numberBetween(1, 100);
        // $posNumber = $this->faker->numberBetween(101, 150);
        $posNumber = $this->faker->numberBetween(103, 152);
        $fnbNumber = $this->faker->numberBetween(1, 20);
        $qty = $this->faker->numberBetween(1, 3);
        $pos = Pos::select('created_at','updated_at')->where('id', '=', $posNumber)->firstOrFail();
        $fnb = FoodNBeverages::where('id', '=', $fnbNumber)->firstOrFail();

        return [
            'id' => $id++,
            'pos_id' => $posNumber,
            'fnb_id' => $fnbNumber,
            'name' => $fnb->name,
            'description' => $fnb->description,
            'type' => $fnb->type,
            'image' => $fnb->image,
            'qty' => $qty,
            'price' => $fnb->price*$qty,
            'created_at' => $pos->created_at,
            'updated_at' => $pos->updated_at,
        ];
    }
}
