<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Stuff;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;
        $suppNumber = $this->faker->unique()->numberBetween(1, 20);
        $posNumber = 'PUR-' . str_pad($id, 6, '0', STR_PAD_LEFT);
        $usernames = User::pluck('username')->toArray();
        $responsible = $this->faker->randomElement($usernames);
        $totalPurch = $this->faker->numberBetween(100000, 1000000);
        $purchName = $this->faker->randomElement(['Air', 'Listrik', 'Internet', 'Transportasi', 'Asuransi', 'Perawatan/Perbaikan', 'Pemasaran/Promosi', 'Sewa Tempat']);
        $state = $this->faker->randomElement(['Dibatalkan', 'Selesai']);
        $total = 0;
        $createdAt = $this->faker->dateTimeBetween('-7 month', 'now');
        $endDate = $this->faker->dateTimeBetween($createdAt, 'now');
        $updatedAt = $endDate->format('Y-m-d H:i:s');
        $endBy = $this->faker->randomElement($usernames);
        
        if ($suppNumber > 10){
            return [
                'id' => $id++,
                'description' => $this->faker->sentence(),
                'purchase_number' => $posNumber,
                'purchase_name' => $purchName,
                'responsible' => $responsible,
                'state' => 'Selesai',
                'total' => $totalPurch,
                'end_date' => $createdAt->format('Y-m-d H:i:s'),
                'created_at' => $createdAt->format('Y-m-d H:i:s'),
                'updated_at' => $createdAt->format('Y-m-d H:i:s'),
            ];
        } else{
            $supplier = Supplier::where('id', '=', $suppNumber)->firstOrFail();
            $supp_id = Stuff::pluck('supplier_id')->toArray();
            $rand_supp = $this->faker->randomElement($supp_id);
            return [
                'id' => $id++,
                'supplier_id' => $rand_supp,
                'supplier_name' => $supplier->supplier_name,
                'description' => $supplier->description,
                'address' => $supplier->address,
                'supplier_responsible' => $supplier->responsible,
                'telp' => $supplier->telp,
                'purchase_number' => $posNumber,
                'purchase_name' => 'Persediaan Bahan',
                'responsible' => $responsible,
                'state' => $state,
                'total' => $total,
                'end_date' => $endDate->format('Y-m-d H:i:s'),
                'end_by' => $endBy,
                'created_at' => $createdAt->format('Y-m-d H:i:s'),
                'updated_at' => $updatedAt,
            ];

        }
    }
}
