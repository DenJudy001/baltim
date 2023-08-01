<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Pos;
use App\Models\User;
use App\Models\Stuff;
use App\Models\Supplier;
use App\Models\DetailPos;
use App\Models\DetailPurchase;
use App\Models\EmployeeSalary;
use App\Models\FoodNBeverages;
use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        FoodNBeverages::factory(20)->create();
        EmployeeSalary::factory(15)->create();
        Pos::factory(100)->create();
        DetailPos::factory(250)->create();
        $posList = Pos::all();
        foreach ($posList as $pos) {
            $total = DetailPos::where('pos_id', $pos->id)->sum('price');
            if ($total > 0) {
                $pos->total = $total;
                DB::table('pos')
                ->where('id', $pos->id)
                ->update(['total' => $total]);
                
            } else {
                $pos->total = $total;
                DB::table('pos')
                ->where('id', $pos->id)
                ->update(['state' => 'Dibatalkan']);
            }
        }
        Purchase::factory(20)->create();
        DetailPurchase::factory(45)->create();
        $purchaseList = Purchase::where('supplier_id','>=',1)->get();
        foreach ($purchaseList as $purch) {
            $total = DetailPurchase::where('purchase_id', $purch->id)->sum('price');
            $purch->total = $total;
            DB::table('purchases')
            ->where('id', $purch->id)
            ->update(['total' => $total]);
        }
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
