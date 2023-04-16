<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\DetailReport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DetailReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailReport $detailReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailReport $detailReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailReport $detailReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailReport $detail_report)
    {  

        DetailReport::destroy($detail_report->id);
        
        session()->flash('success', 'Data Berhasil Dihapus');
    }

    public function updateDetailReport(Request $request)
    {
        $reportID = $request->report_id;
        $reportData = Report::find($reportID);
        if ($request->id){
            if ($request->type == 'Asset'){
                $rules = [
                    'name' => ['required',Rule::unique('detail_reports')->where(function ($query){
                        return $query->where('type', 'Asset');
                    })->ignore($request->id)],
                    'month_asset' => 'required',
                    'year_asset' => "required|integer|min:1900|max:{$reportData->report_year}",
                    'price' => 'required|integer|min:1',
                ];
    
                $validatedDataStuff = $request->validate($rules);
                $validatedDataStuff['name'] = ucwords($request->name);
                $validatedDataStuff['type'] = $request->type;
    
                DetailReport::where('id', $request->id)
                ->update($validatedDataStuff);            
                session()->flash('success', 'Berhasil merubah data aset');
            } else if ($request->type == 'Persediaan'){
                $rules = [
                    'name' => ['required',Rule::unique('detail_reports')->where(function ($query){
                        return $query->where('type', 'Persediaan');
                    })->ignore($request->id)],
                    'price' => 'required|integer|min:1',
                ];
    
                $validatedDataStuff = $request->validate($rules);
                $validatedDataStuff['name'] = ucwords($request->name);
                $validatedDataStuff['type'] = $request->type;
    
                DetailReport::where('id', $request->id)
                ->update($validatedDataStuff);            
                session()->flash('success', 'Berhasil merubah data persediaan');
            }
        }else{
            if ($request->type == 'Asset'){
                $rules = [
                    'name' => ['required',Rule::unique('detail_reports')->where(function ($query){
                        return $query->where('type', 'Asset');
                    })],
                    'month_asset' => 'required',
                    'year_asset' => "required|integer|min:1900|max:{$reportData->report_year}",
                    'price' => 'required|integer|min:1',
                ];
    
                $validatedDataStuff = $request->validate($rules);
                $validatedDataStuff['name'] = ucwords($request->name);
                $validatedDataStuff['report_id'] = $reportID;
                $validatedDataStuff['type'] = $request->type;
    
                DetailReport::create($validatedDataStuff);
                session()->flash('success', 'Berhasil menambahkan data aset');
            } else if ($request->type == 'Persediaan'){
                $rules = [
                    'name' => ['required',Rule::unique('detail_reports')->where(function ($query){
                        return $query->where('type', 'Persediaan');
                    })],
                    'price' => 'required|integer|min:1',
                ];
    
                $validatedDataStuff = $request->validate($rules);
                $validatedDataStuff['name'] = ucwords($request->name);
                $validatedDataStuff['report_id'] = $reportID;
                $validatedDataStuff['type'] = $request->type;
    
                DetailReport::create($validatedDataStuff);
                session()->flash('success', 'Berhasil menambahkan data persediaan');
            }
            
        }
    }
}
