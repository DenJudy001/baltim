<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pos>
 */
class PosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $id = 1;
        $posNumber = 'TRX-' . str_pad($id, 6, '0', STR_PAD_LEFT);
        $usernames = User::where('username', '!=', 'baltim')->pluck('username')->toArray();
        $usernames2 = User::pluck('username')->toArray();
        $responsible = $this->faker->randomElement($usernames);
        $state = $this->faker->randomElement(['Dibatalkan', 'Selesai', 'Selesai']);
        $total = 0;
        $createdAt = $this->faker->dateTimeBetween('-7 month', 'now');
        $endDate = $this->faker->dateTimeBetween($createdAt, 'now');
        $updatedAt = $endDate->format('Y-m-d H:i:s');
        $endBy = $this->faker->randomElement($usernames2);

        return [
            'id' => $id++,
            'pos_number' => $posNumber,
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
