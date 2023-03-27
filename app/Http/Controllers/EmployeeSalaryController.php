<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EmployeeSalary;
use App\Http\Controllers\Controller;

class EmployeeSalaryController extends Controller
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
        $employee = User::where('is_admin', false)->get();

        return view('dashboard.salary.create', compact('employee'));
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

        EmployeeSalary::create($validatedData);
        return redirect('/account')->with('success','Berhasil Menambah Upah Karyawan');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeSalary $employeeSalary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeSalary $employeeSalary)
    {
        //
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
        //
    }
}