<?php

namespace Database\Seeders;

use App\Models\Pos;
use App\Models\Purchase;
use App\Models\DetailPos;
use App\Models\DetailPurchase;
use App\Models\EmployeeSalary;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeSalary::factory(1)->create();
        Pos::factory(50)->create();
        DetailPos::factory(125)->create();
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
        Purchase::factory(15)->create();
        DetailPurchase::factory(30)->create();
        $purchaseList = Purchase::where('supplier_id','>=',1)->get();
        foreach ($purchaseList as $purch) {
            $total = DetailPurchase::where('purchase_id', $purch->id)->sum('price');
            $purch->total = $total;
            DB::table('purchases')
            ->where('id', $purch->id)
            ->update(['total' => $total]);
        }
    }
}
