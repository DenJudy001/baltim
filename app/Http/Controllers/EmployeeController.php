<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.employee.index',[
            'users'=>User::select('id','name','telp','username')->where('is_admin','!=',true)->get(),
            'title'=>"Daftar Karyawan"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.employee.create',[
            'title'=>"Buat Akun Karyawan"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users',
            'telp' => 'required|min:9|max:15|unique:users',
            'salary' => 'required|integer|min:0',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);
        

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        return redirect('/employee')->with('success','Berhasil Menambah Karyawan Baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //buat if admin if user redirect back
        return view('dashboard.employee.show',[
            'employee'=>$user,
            'title'=>"Info Karyawan"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->id == auth()->user()->id){
            return view('dashboard.employee.edit',[
                'employee'=>$user,
                'title'=>"Ubah Profil"
            ]);
        } else {
            return redirect()->back();
        }
        
    }

    public function editSalary(User $user)
    {
        if (auth()->user()->is_admin){
            return view('dashboard.employee.edit_salary',[
                'employee'=>$user,
                'title'=>"Ubah Gaji Karyawan"
            ]);
        } else {
            return abort(403);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules =[
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'telp' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
        ];
        
        $validatedData = $request -> validate($rules);
        User::where('id', $user->id)
            ->update($validatedData);

        return redirect()->back()->with('success','Berhasil Ubah Data Profil');
    }

    public function changeSalary(Request $request, User $user)
    {
        $rules =[
            'salary' => 'required|integer|min:0'
        ];
        
        $validatedData = $request->validate($rules);
        User::where('id', $user->id)
            ->update($validatedData);

        return redirect('/employee')->with('success','Berhasil Ubah Data Gaji');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);

        session()->flash('success', 'Berhasil Hapus Karyawan');
    }

    public function indexChangePassword(User $user)
    {
        if ($user->id == auth()->user()->id){
            return view('dashboard.employee.change-password',[
                'employee'=>$user,
                'title'=>"Ubah Kata Sandi"
            ]);
        } else {
            return redirect()->back();
        }
    }
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:5',
        ],[
            'old_password.required' => 'Silakan masukkan kata sandi saat ini.',
            'password.required' => 'Silakan masukkan kata sandi baru.',
            'password.confirmed' => 'Kata sandi baru dan konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi baru harus memiliki setidaknya :min karakter.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }
    
        $user = auth()->user()->id;
        $old_password = auth()->user()->password;
    
        if (Hash::check($request->old_password, $old_password)) {
            User::where('id', $user)
            ->update(['password'=>Hash::make($request->password)]);
    
            return redirect('/')->with('success', 'Kata Sandi berhasil diubah!');
        } else {
            $validator->errors()->add('old_password', 'Kata Sandi lama salah.');
            return back()->withErrors($validator);
        }
    }
}
