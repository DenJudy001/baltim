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
        $pur_filter = request('pur');
        $trx_filter = request('trx');
        
        if ($pur_filter != null){
            if ($start_date && $end_date != null){
                $start_date = request('start_date').' 00:00:00';
                $end_date = request('end_date').' 23:59:59';
                $purchase = DB::table('purchases')
                    ->select('purchase_number', 'total', 'state', 'created_at','updated_at')
                    ->where('state', '=', 'Proses')
                    ->whereBetween('updated_at', [$start_date, $end_date]);

                $pos = DB::table('pos')
                    ->select('pos_number', 'total', 'state', 'created_at','updated_at')
                    ->where('state', '=', 'end')
                    ->whereBetween('updated_at', [$start_date, $end_date]);
            } else {
                $purchase = DB::table('purchases')
                ->select('purchase_number', 'total', 'state', 'created_at','updated_at')
                ->where('state', '=', 'Proses');

                $pos = DB::table('pos')
                ->select('pos_number', 'total', 'state', 'created_at','updated_at')
                ->where('state', '=', 'end');
            }
            $transactions = $purchase->union($pos)->orderBy('updated_at', 'desc')->get();
        } else if ($trx_filter != null){
            if ($start_date && $end_date != null){
                $start_date = request('start_date').' 00:00:00';
                $end_date = request('end_date').' 23:59:59';
                $purchase = DB::table('purchases')
                    ->select('purchase_number', 'total', 'state', 'created_at','updated_at')
                    ->where('state', '=', 'end')
                    ->whereBetween('updated_at', [$start_date, $end_date]);
                $pos = DB::table('pos')
                    ->select('pos_number', 'total', 'state', 'created_at','updated_at')
                    ->where('state', '=', 'Proses')
                    ->whereBetween('updated_at', [$start_date, $end_date]);
            } else {
                $purchase = DB::table('purchases')
                ->select('purchase_number', 'total', 'state', 'created_at','updated_at')
                ->where('state', '=', 'end');

                $pos = DB::table('pos')
                ->select('pos_number', 'total', 'state', 'created_at','updated_at')
                ->where('state', '=', 'Proses');
            }
            $transactions = $purchase->union($pos)->orderBy('updated_at', 'desc')->get();
        } else {
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
        }
        

        $title = "Riwayat Transaksi";
        $pendingNoticeIncome = 0;
        $pendingNoticeExpense = 0;

        //untuk seluruh data
        foreach($transactions as $data){
            if ($pur_filter != null || $trx_filter != null) {
                $pendingNoticeIncome = 0;
                $pendingNoticeExpense = 0;
            } else {
                if($data->state == "Proses" && str_contains($data->purchase_number, 'TRX')){
                    $pendingNoticeIncome += $data->total;
                } else if($data->state == "Proses" && str_contains($data->purchase_number, 'PUR')){
                    $pendingNoticeExpense += $data->total;
                }
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

    public function transactionsToday(Request $request){
        $type = $request->type;
        $posToday = DB::table('pos')
            ->select('pos_number', 'total', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));
        $salaryToday = DB::table('employee_salaries')
            ->select('salary_number', 'salary', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));
        $purchaseToday = DB::table('purchases')
            ->select('purchase_number', 'total', 'state', 'updated_at')
            ->whereDate('updated_at', '=', date('Y-m-d'));

        if($request->type == 'income'){
            if($request->status == 'pending'){
                $transactions = $posToday->where('state', '=', 'Proses')->get();
                $posTodayTotal = $posToday->where('state', '=', 'Proses')->sum('total');
                $total = $posTodayTotal;
                $title = "Transaksi Pemasukan (Tertunda)";
            }
            elseif($request->status == 'net'){
                $transactions = $posToday->where('state', '=', 'Selesai')->get();
                $posTodayTotal = $posToday->where('state', '=', 'Selesai')->sum('total');
                $total = $posTodayTotal;
                $title = "Transaksi Pemasukan (Selesai)";
            }
            else{
                $transactions = $posToday->where('state', '!=', 'Dibatalkan')->get();
                $posTodayTotal = $posToday->where('state', '!=', 'Dibatalkan')->sum('total');
                $total = $posTodayTotal;
                $title = "Transaksi Pemasukan (Semua)";
            }
        }
        elseif($request->type == 'expense'){
            if($request->status == 'pending'){               
                $purchaseTodayTotal = $purchaseToday->where('state', '=', 'Proses')->sum('total');
                $transactions = $purchaseToday->where('state', '=', 'Proses')->get();
                $total = $purchaseTodayTotal;
                $title = "Transaksi Pengeluaran (Tertunda)";
            }
            elseif($request->status == 'net'){              
                $purchaseTodayTotal = $purchaseToday->where('state', '=', 'Selesai')->sum('total');
                $salaryTodayTotal = $salaryToday->sum('salary');
                $transactions = $purchaseToday->where('state', '=', 'Selesai')->union($salaryToday)->get();
                $total = $salaryTodayTotal+$purchaseTodayTotal;
                $title = "Transaksi Pengeluaran (Selesai)";
            }
            else{
                $purchaseTodayTotal = $purchaseToday->where('state', '!=', 'Dibatalkan')->sum('total');
                $salaryTodayTotal = $salaryToday->sum('salary');
                $transactions = $purchaseToday->where('state', '!=', 'Dibatalkan')->union($salaryToday)->get();
                $total = $salaryTodayTotal+$purchaseTodayTotal;
                $title = "Transaksi Pengeluaran (Semua)";
            }
        }

        return view('dashboard.account.recap-today', compact('transactions','total','type','title'));
    }


}
