<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Report;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\EmployeeSalary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailReport;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function labaRugiIndex() {
        return view('dashboard.report.laba_rugi',[
            'title'=>"Buat Laporan Laba Rugi"
        ]);
    }

    public function calkIndex() {
        $periode = Report::first();
        return view('dashboard.report.calk',[
            'title'=>"Buat Catatan Atas Laporan Keuangan",
            'periode'=> $periode
        ]);
    }
    public function posisiKeuanganIndex() {
        $reportData = Report::first();

        if ($reportData != null){
            return view('dashboard.report.posisi_keuangan_lock',[
                'title'=>"Buat Laporan Posisi Keuangan",
                'report'=>$reportData
            ]);
        } else {
            return view('dashboard.report.posisi_keuangan',[
                'title'=>"Buat Laporan Posisi Keuangan"
            ]);
        }
    }

    public function posisiKeuanganEdit(Report $id) {
        return view('dashboard.report.posisi_keuangan_edit',[
            'title'=>"Buat Laporan Posisi Keuangan",
            'report'=>$id
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

    public function createKeuangan(Request $request)
    {
        // dd($request);
        $validatedDataSupp = $request->validate([
            'report_year' => 'required',
            'report_periode' => 'required',
            'kas' => 'required',
            'piutang' => 'required',
            'utang_usaha' => 'required',
            'utang_bank' => 'required',
        ]);
        
        $reportData = Report::create($validatedDataSupp);
        $report_id = $reportData->id;
        $bangunanCreate = DetailReport::create([
            'name' => 'Bangunan',
            'price' => $request->priceBangunan,
            'month_asset' => '',
            'year_asset' => '',
            'report_id' => $report_id,
            'type' => 'Asset Bangunan',
        ]);
        $arr_input= [];
        $arr_inputAsset= [];

        if($request->supply_name){
            $supply_names = $request->supply_name;
            $supply_prices = $request->supply_price;
            for ($i=0; $i<count($supply_names); $i++){
                $arr_input[] = [
                    'name' => $supply_names[$i],
                    'price' => $supply_prices[$i],
                    'report_id' => $report_id,
                    'type' => 'Persediaan',
                ];
            }

            $validator = Validator::make($arr_input, [
                '*.name' => 'required|min:2',
                '*.price' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                Report::destroy($report_id);
                DetailReport::destroy($bangunanCreate->id);

                $supplyNames = array_column($arr_input, 'name');
                if (count($supplyNames) !== count(array_unique($supplyNames))){
                    return redirect()->back()->with('error_validate','Gagal! nama persediaan tidak boleh sama ')->withErrors($validator->errors())->withInput();
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else{
                

                $supplyNames = array_column($arr_input, 'name');
                if (count($supplyNames) !== count(array_unique($supplyNames))){
                    Report::destroy($report_id);
                    DetailReport::destroy($bangunanCreate->id);
                    return redirect()->back()->with('error_unique','Gagal! nama persediaan tidak boleh sama ')->withInput();
                }
            }
        }
        if($request->name_asset){
            $asset_names = $request->name_asset;
            $asset_prices = $request->price_asset;
            $asset_months = $request->month_asset;
            $asset_years = $request->year_asset;
            
            for ($i=0; $i<count($asset_names); $i++){
                $arr_inputAsset[] = [
                    'name' => $asset_names[$i],
                    'price' => $asset_prices[$i],
                    'month_asset' => $asset_months[$i],
                    'year_asset' => $asset_years[$i],
                    'report_id' => $report_id,
                    'type' => 'Asset',
                ];
            }

            $validator2 = Validator::make($arr_inputAsset, [
                '*.name' => 'required|min:2',
                '*.price' => 'required|integer|min:1',
                '*.month_asset' => 'required',
                '*.year_asset' => 'required',
            ]);

            if ($validator2->fails()) {
                Report::destroy($report_id);

                $assetNames = array_column($arr_inputAsset, 'name');
                if (count($assetNames) !== count(array_unique($assetNames))){
                    return redirect()->back()->with('error_validate','Gagal! nama aset tidak boleh sama ')->withErrors($validator->errors())->withInput();
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else{

                $assetNames = array_column($arr_inputAsset, 'name');
                if (count($assetNames) !== count(array_unique($assetNames))){
                    Report::destroy($report_id);
                    return redirect()->back()->with('error_unique','Gagal! nama aset tidak boleh sama ')->withInput();
                }
            }
        }

        if($request->supply_name){
            for ($i=0; $i<count($arr_input); $i++){
                $arr_input[$i]['name'] = ucwords($request->supply_name[$i]);
                DetailReport::create([
                    'report_id' => $arr_input[$i]['report_id'],
                    'name' => $arr_input[$i]['name'],
                    'type' => $arr_input[$i]['type'],
                    'price' => $arr_input[$i]['price']
                ]);
            }
        }

        if($request->name_asset){
            for ($i=0; $i<count($arr_inputAsset); $i++){
                $arr_inputAsset[$i]['name'] = ucwords($request->name_asset[$i]);
                DetailReport::create([
                    'report_id' => $arr_inputAsset[$i]['report_id'],
                    'name' => $arr_inputAsset[$i]['name'],
                    'type' => $arr_inputAsset[$i]['type'],
                    'month_asset' => $arr_inputAsset[$i]['month_asset'],
                    'year_asset' => $arr_inputAsset[$i]['year_asset'],
                    'price' => $arr_inputAsset[$i]['price']
                ]);
            }
        }
        
        
        return redirect('/report/posisi-keuangan')->with('success','Berhasil menyimpan data laporan posisi keuangan! ');
    }

    public function updateKeuangan(Report $report, Request $request)
    {
        $rules = [
            'report_year' => 'required',
            'report_periode' => 'required',
            'kas' => 'required',
            'piutang' => 'required',
            'utang_usaha' => 'required',
            'utang_bank' => 'required',
        ];

        $rules2 = [
            'priceBangunan' => 'required'
        ];

        $validatedDataSupp = $request->validate($rules);
        $validatedDataSupp2 = $request->validate($rules2);

        $validatedDataSupp2['price'] = $validatedDataSupp2['priceBangunan'];
        unset($validatedDataSupp2['priceBangunan']);

        Report::where('id',$report->id)->update($validatedDataSupp);
        DetailReport::where('id',$report->dtl_reports->where('type','Asset Bangunan')->first()->id)->update($validatedDataSupp2);



        return redirect('/report/posisi-keuangan')->with('success','Berhasil menyimpan data laporan posisi keuangan! ');
    }

    public function keuanganDownload(Report $report)
    {
        $year = $report->report_year;
        $month = $report->report_periode;
        $endDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $asetBangunan = $report->dtl_reports->where('type','Asset Bangunan')->first()->price;

        $totalSupply = 0;
        $totalAsset = 0;
        $groupedAsset = [];
        
        foreach($report->dtl_reports->where('type','Persediaan') as $data){
            $totalSupply += $data->price;
        }

        foreach($report->dtl_reports->where('type','Asset') as $data){
            //standar penyusutan = 4 tahun (25%)
            $bebanTahun = $data->price * 0.25;
            $bebanBulan = $bebanTahun/12;
            $diffYear = $year-$data->year_asset;
            $diffMonth = $month-$data->month_asset;
            $bebanTotal = 0;

            if($diffYear > 0) {
                $bebanTotal += $diffYear*$bebanTahun;
            }else {
                if ($diffMonth > 0) {
                    $bebanTotal = $diffMonth*$bebanBulan;
                } else{
                    $bebanTotal = 0;
                }
            }

            if($bebanTotal > $data->price){
                $bebanTotal = $data->price;
            }

            $groupedAsset[] = [
                'name'=> $data->name,
                'year'=> $diffYear,
                'month'=> $diffMonth,
                'price'=> $data->price,
                'beban'=> $bebanTotal
            ];

            if($diffYear > 0){
                $totalAsset = $totalAsset + ($data->price-$bebanTotal);
            } else if($diffYear == 0){
                if($diffMonth >= 0){
                    $totalAsset = $totalAsset + ($data->price-$bebanTotal);
                }
            }
        }
        
        $totalAsetLancar = $report->kas+$report->piutang+$totalSupply;
        $totalAsetLnT = $totalAsetLancar+$totalAsset+$asetBangunan;
        $totalutang = $report->utang_usaha+$report->utang_bank;
        $totalModal = $totalAsetLnT-$totalutang;
        $totalLnE = $totalModal+$totalutang;

        // dd($groupedAsset);
        $pdf = Pdf::loadView('dashboard.report.posisi_keuangan_pdf', [
            'report' => $report,
            'asset'=> $groupedAsset,
            'supply' => $totalSupply,
            'totalAsetLancar' => $totalAsetLancar,
            'totalAsetTetap' => $totalAsset+$asetBangunan,
            'totalAset' => $totalAsetLnT,
            'totalLiabilitas' => $totalutang,
            'modal' => $totalModal,
            'totalLnE' => $totalLnE,
            'asetBangunan' => $asetBangunan,
            'date' => $endDays,
            'month' => $monthName,
            'year'=> $year
        ]);
        return $pdf->stream('laporan-posisi-keuangan.pdf');

    }

    public function calkDownload(Report $report)
    {
        $year = $report->report_year;
        $month = $report->report_periode;
        $endDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $startDate = $year.'-'.$month.'-01 00:00:00';
        $endDate = $year.'-'.$month.'-'.$endDays.' 23:59:59';
        $asetBangunan = $report->dtl_reports->where('type','Asset Bangunan')->first()->price;
        $supplyData = $report->dtl_reports->where('type','Persediaan');
        $income = Pos::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('total');
        $salary = EmployeeSalary::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->sum('salary');
        $purchase = Purchase::where('state', '=', 'Selesai')
                    ->whereBetween('updated_at', [$startDate, $endDate])
                    ->get();

        $totalSupply = 0;
        $totalAsset = 0;
        $groupedAsset = [];
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
        
        foreach($report->dtl_reports->where('type','Persediaan') as $data){
            $totalSupply += $data->price;
        }

        foreach($report->dtl_reports->where('type','Asset') as $data){
            //standar penyusutan = 4 tahun (25%)
            $bebanTahun = $data->price * 0.25;
            $bebanBulan = $bebanTahun/12;
            $diffYear = $year-$data->year_asset;
            $diffMonth = $month-$data->month_asset;
            $bebanTotal = 0;

            if($diffYear > 0) {
                $bebanTotal += $diffYear*$bebanTahun;
            }else {
                if ($diffMonth > 0) {
                    $bebanTotal = $diffMonth*$bebanBulan;
                } else{
                    $bebanTotal = 0;
                }
            }

            if($bebanTotal > $data->price){
                $bebanTotal = $data->price;
            }

            $groupedAsset[] = [
                'name'=> $data->name,
                'year'=> $diffYear,
                'month'=> $diffMonth,
                'price'=> $data->price,
                'beban'=> $bebanTotal
            ];

            if($diffYear > 0){
                $totalAsset = $totalAsset + ($data->price-$bebanTotal);
            } else if($diffYear == 0){
                if($diffMonth >= 0){
                    $totalAsset = $totalAsset + ($data->price-$bebanTotal);
                }
            }
        }

        $pdf = Pdf::loadView('dashboard.report.calk_pdf', [
            'report' => $report,
            'supply'=> $supplyData,
            'totalPersediaan' => $totalSupply,
            'asetBangunan' => $asetBangunan,
            'asset'=> $groupedAsset,
            'totalAsetTetap' => $totalAsset+$asetBangunan,
            'income' => $income,
            'salary' => $salary,
            'expense' => $groupedPurchase,
            'expenseTotal' => $expenseTotal,
            'date' => $endDays,
            'month' => $monthName,
            'year'=> $year
        ]);
        return $pdf->stream('catatan-atas-laporan-keuangan.pdf');
    }
}
