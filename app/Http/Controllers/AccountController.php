<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(){

        $purchase = DB::table('purchases')
        ->select('purchase_number', 'total', 'state', 'updated_at');

        $salary = DB::table('employee_salaries')
        ->select('salary_number', 'salary', 'state', 'updated_at');

        $pos = DB::table('pos')->select('pos_number', 'total', 'state', 'updated_at');

        $transactions = $purchase->union($salary)->union($pos)->orderBy('updated_at', 'desc')->get();
        $title = "Catatan Keuangan";

        $posData = $pos->get();
        $salaryData = $salary->get();
        $purchaseData = $purchase->get();
        $totalIncome = 0;
        $pendingIncome = 0;
        $confirmedIncome = 0;
        $totalExpense = 0;
        $pendingExpense = 0;
        $confirmedExpense = 0;


        foreach ($posData as $data){
            if($data->state == "Proses"){
                $pendingIncome += $data->total;
                $totalIncome += $data->total;
            } else if($data->state == "Selesai"){
                $confirmedIncome += $data->total;
                $totalIncome += $data->total;
            }
        }

        foreach($salaryData as $data){
            if($data->state == "Proses"){
                $pendingExpense += $data->salary;
                $totalExpense += $data->salary;
            } else if($data->state == "Selesai"){
                $confirmedExpense += $data->salary;
                $totalExpense += $data->salary;
            }
        }
        
        foreach($purchaseData as $data){
            if($data->state == "Proses"){
                $pendingExpense += $data->total;
                $totalExpense += $data->total;
            } else if($data->state == "Selesai"){
                $confirmedExpense += $data->total;
                $totalExpense += $data->total;
            }
        }


        return view('dashboard.account.index', compact('transactions','title','totalIncome','pendingIncome','confirmedIncome','totalExpense','pendingExpense','confirmedExpense'));
    }


}
