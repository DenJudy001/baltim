<?php

namespace Database\Factories;

use App\Models\Stuff;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailPurchase>
 */
class DetailPurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;
        $purchNumber = $this->faker->numberBetween(1, 5);
        $supp_id = Purchase::select('supplier_id','created_at','updated_at')->where('id', '=', $purchNumber)->firstOrFail();
        if ($supp_id->supplier_id >= 1) {
            $stuff = Stuff::where('supplier_id', '=', $supp_id->supplier_id)->firstOrFail();
            $qty = $this->faker->numberBetween(1, 3);
            $unit = $this->faker->randomElement(['kg (kilogram)', 'gr (gram)', 'ltr (liter)', 'ekor', 'lembar']);
            
            return [
                'id' => $id++,
                'purchase_id' => $purchNumber,
                'name' => $stuff->stuff_name,
                'description' => $stuff->description,
                'qty' => $qty,
                'unit' => $unit,
                'price' => $stuff->price*$qty,
                'created_at' => $supp_id->created_at,
                'updated_at' => $supp_id->updated_at,
            ];
        } else {
            return [
                //
            ];
        }
    }
}
