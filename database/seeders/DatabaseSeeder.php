<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\FoodNBeverages;
use App\Models\User;
use App\Models\Stuff;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(4)->create();
        Supplier::factory(5)->create();
        Stuff::factory(10)->create();
        FoodNBeverages::factory(10)->create();
        User::create([
           'name' => "RM Baltim",
           'username' => "baltim",
           'telp' => "123123",
           'email' => "baltim@gmail.com",
           'password' => bcrypt('12345'),
           'is_admin' => True
        ]);
    }
}
