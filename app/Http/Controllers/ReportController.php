<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\EmployeeSalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function labaRugiIndex() {
        return view('dashboard.report.laba_rugi',[
            'title'=>"Buat Laporan Laba Rugi"
        ]);
    }

    public function labaRugiDownload(Request $request)
    {
        $year = $request->year;
        $month = $request->periode;
        $endDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $startDate = $year.'-'.$month.'-01 00:00:00';
        $endDate = $year.'-'.$month.'-'.$endDays.' 23:59:59';

        $purchase = Purchase::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->get();

        $salary = EmployeeSalary::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('salary');

        $pos = Pos::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('total');

        $groupedPurchase = [];

        foreach ($purchase as $data){
            $name = $data->purchase_name;
            $total = $data->total;
            if (isset($groupedPurchase[$name])) {
                $groupedPurchase[$name]['total'] += $total;
            } else {
                $groupedPurchase[$name] = [
                    'name' => $name,
                    'total' => $total
                ];
            }
        }
        $expenseTotal = $salary;
        foreach($groupedPurchase as $item){
            $expenseTotal+=$item['total'];
        }

        $labaRugi = $pos-$expenseTotal;
        // $tax = 0.005 * $labaRugi;
        // $labaRugiTotal = $labaRugi-$tax;

                    
        $pdf = Pdf::loadView('dashboard.report.laba_rugi_pdf', [
            'expense' => $groupedPurchase,
            'salary' => $salary,
            'income' => $pos,
            'expenseTotal' => $expenseTotal,
            'labaRugi' => $labaRugi,
            'date' => $endDays,
            'month' => $monthName,
            'year'=> $year
        ]);
        return $pdf->stream('laporan-laba-rugi.pdf');

    }
}
