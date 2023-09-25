<?php

namespace Database\Factories;

use App\Models\EmployeeSalary;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeSalary>
 */
class EmployeeSalaryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // static $id = 1;
        // static $id = 16;
        static $id = 17;
        $salNumber = 'SAL-' . str_pad($id, 6, '0', STR_PAD_LEFT);
        $usernames = User::where('username', '!=', 'baltim')->pluck('id')->toArray();
        $user_id = $this->faker->randomElement($usernames);
        $user = User::where('id','=',$user_id)->firstOrFail();
        $salary = $this->faker->numberBetween(600000, 600999);
        // $createdAt = $this->faker->dateTimeBetween('-8 month', 'now');
        $createdAt = $this->faker->dateTimeBetween('2023-09-01 00:00:00', '2023-09-30 23:59:59');

        return [
            'id' => $id++,
            'user_id' => $user_id,
            'salary_number' => $salNumber,
            'name' => $user->name,
            'email' => $user->email,
            'telp' => $user->telp,
            'state' => 'Selesai',
            'salary' => $salary,
            'end_by' => 'baltim',
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
