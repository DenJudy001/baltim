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
        // static $id = 1;
        // static $id = 46;
        static $id = 55;
        $supp_id = Purchase::where('supplier_id', '>=', 1)->pluck('id')->toArray();
        $rand_supp = $this->faker->randomElement($supp_id);
        $supplier = Purchase::select('supplier_id','created_at','updated_at')->where('id','=', $rand_supp)->firstOrFail();
        $number_stuff = Stuff::where('supplier_id', '=', $supplier->supplier_id)->pluck('id')->toArray();
        $rand_stuff = $this->faker->randomElement($number_stuff);
        $stuff = Stuff::where('id', '=', $rand_stuff)->firstOrFail();
        $qty = $this->faker->numberBetween(1, 3);
        $unit = $this->faker->randomElement(['kg (kilogram)', 'gr (gram)', 'ltr (liter)', 'ekor', 'lembar']);
        
        return [
            'id' => $id++,
            'purchase_id' => $rand_supp,
            'name' => $stuff->stuff_name,
            'description' => $stuff->description,
            'qty' => $qty,
            'unit' => $unit,
            'price' => $stuff->price*$qty,
            'created_at' => $supplier->created_at,
            'updated_at' => $supplier->updated_at,
        ];
        
    }
}
