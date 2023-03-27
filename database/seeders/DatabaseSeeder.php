<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Series;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(4)->create();
        User::create([
           'name' => "RM Baltim",
           'username' => "baltim",
           'telp' => "123123",
           'email' => "baltim@gmail.com",
           'password' => bcrypt('12345'),
           'is_admin' => True
        ]);

        Series::create([
            'series_name' => "ORD"
        ]);
        Series::create([
            'series_name' => "TRX"
        ]);
        Series::create([
            'series_name' => "SAL"
        ]);
    }
}
