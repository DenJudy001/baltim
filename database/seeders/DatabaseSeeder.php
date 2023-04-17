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
        User::factory(19)->create();
        Supplier::factory(20)->create();
        Stuff::factory(40)->create();
        FoodNBeverages::factory(40)->create();
        User::create([
           'name' => "RM Baltim",
           'username' => "baltim",
           'telp' => "6287824009898",
           'email' => "baltim@gmail.com",
           'password' => bcrypt('12345'),
           'is_admin' => True
        ]);
    }
}
