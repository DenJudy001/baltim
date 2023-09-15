@extends('dashboard.layouts.main')

@section('container')
@if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/employee">Daftar Karyawan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Gaji Karyawan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Akun</h4></div>
        </div>
    </div>
    <div class="card-body">
        <form action="/employee/{{ $employee->username }}/edit-salary" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Nama Karyawan</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{ $employee->name }}   
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="38%" >Username</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{ $employee->username }}   
                        </td>
                    </tr>

                    <tr>
                        <td width="38%" >Gaji</td>
                        <td width="2%" >:</td>
                        <td width="60%" >
                            <input type="number" class="form-control" id="salary" name="salary" value="{{ old('salary',$employee->salary) }}" min="0" required autofocus onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Isikan 0 jika kosong !')" oninput="this.setCustomValidity('')">
                            @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Email</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{ $employee->email }}   
                        </td>
                    </tr>                
                    <tr>
                        <td width="38%" >No. Telp</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{ $employee->telp }}   
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary"><i class="fas fa-pen mr-2"></i>Ubah Gaji</button>
            </div>
        </form>
        </div>              
    </div>
</div>
@endsection