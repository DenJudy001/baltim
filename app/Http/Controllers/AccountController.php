<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(){
        $title = "Transaksi Hari Ini";

        $posToday = DB::table('pos')
            ->select('pos_number', 'total', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));

        $salaryToday = DB::table('employee_salaries')
            ->select('salary_number', 'salary', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));

        $purchaseToday = DB::table('purchases')
            ->select('purchase_number', 'total', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));

        $posData = $posToday->get();
        $salaryData = $salaryToday->get();
        $purchaseData = $purchaseToday->get();
        $totalIncome = 0;
        $pendingIncome = 0;
        $confirmedIncome = 0;
        $totalExpense = 0;
        $pendingExpense = 0;
        $confirmedExpense = 0;

        //untuk hari ini
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

        return view('dashboard.account.index', compact('title','totalIncome','pendingIncome','confirmedIncome','totalExpense','pendingExpense','confirmedExpense'));
    }

    public function transactions(){

        $start_date = request('start_date');
        $end_date = request('end_date');

        if ($start_date && $end_date != null){
            $start_date = request('start_date').' 00:00:00';
            $end_date = request('end_date').' 23:59:59';
            $purchase = DB::table('purchases')
                ->select('purchase_number', 'total', 'state', 'created_at','updated_at')
                ->whereBetween('updated_at', [$start_date, $end_date]);

            $salary = DB::table('employee_salaries')
                ->select('salary_number', 'salary', 'state', 'created_at','updated_at')
                ->whereBetween('updated_at', [$start_date, $end_date]);

            $pos = DB::table('pos')
                ->select('pos_number', 'total', 'state', 'created_at','updated_at')
                ->whereBetween('updated_at', [$start_date, $end_date]);
        } else {
            $purchase = DB::table('purchases')
            ->select('purchase_number', 'total', 'state', 'created_at','updated_at');

            $salary = DB::table('employee_salaries')
            ->select('salary_number', 'salary', 'state', 'created_at','updated_at');

            $pos = DB::table('pos')->select('pos_number', 'total', 'state', 'created_at','updated_at');
        }

        $transactions = $purchase->union($salary)->union($pos)->orderBy('updated_at', 'desc')->get();
        $title = "Riwayat Transaksi";
        $pendingNoticeIncome = 0;
        $pendingNoticeExpense = 0;

        //untuk seluruh data
        foreach($transactions as $data){
            if($data->state == "Proses" && str_contains($data->purchase_number, 'TRX')){
                $pendingNoticeIncome += $data->total;
            }
        }
        foreach($transactions as $data){
            if($data->state == "Proses" && str_contains($data->purchase_number, 'PUR')){
                $pendingNoticeExpense += $data->total;
            }
        }

        if($pendingNoticeIncome > 1){
            session()->flash('trx-notice', 'terdapat transaksi (TRX-XXX) yang belum diselesaikan');
        }
        if($pendingNoticeExpense > 1){
            session()->flash('pur-notice', 'terdapat pengeluaran (PUR-XXX) yang belum diselesaikan');
        }

        return view('dashboard.account.transactions', compact('transactions','title'));
    }


}
