<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmployeeSalary;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect("/salary/create");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employee = User::where('is_admin', false)->get();
        $title = "Pembayaran Gaji";

        return view('dashboard.salary.create', compact('employee','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request ->validate([
            'user_id' => 'required',
            'salary' => 'required',
        ]);

        $validatedData['name'] = $request->name;
        $validatedData['email'] = $request->email;
        $validatedData['telp'] = $request->telp;
        $validatedData['state'] = 'Selesai';
        $validatedData['end_by'] = auth()->user()->username;
        $validatedData['salary_number'] = IdGenerator::generate(['table' => 'employee_salaries', 'length' => 10, 'prefix' =>'SAL-','reset_on_prefix_change' => true ,'field' => 'salary_number']);

        EmployeeSalary::create($validatedData);
        return redirect('/transactions')->with('success','Berhasil Menambah Gaji Karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        if($employeeSalary->email == auth()->user()->email || auth()->user()->is_admin){
            return view('dashboard.salary.show',[
                'salary'=>$employeeSalary,
                'title'=>"Info Gaji Karyawan"
            ]);
        }
        else{
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        if($employeeSalary->email == auth()->user()->email || auth()->user()->is_admin){
            return view('dashboard.salary.editlock',[
                'salary'=>$employeeSalary,
                'announce' => 'Pembayaran jenis ini tidak dapat diubah',
                'title'=>"Ubah Gaji Karyawan"
            ]);
        }
        else{
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeSalary $employeeSalary)
    {
        EmployeeSalary::destroy($employeeSalary->id);

        session()->flash('success', 'Transaksi Berhasil Dihapus');
    }
}
