@extends('dashboard.layouts.main')

@section('container')
@if (session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Akun</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <form action="/employee/{{ $employee->id }}" method="post">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Nama Karyawan</td>
                        <td width="2%" >:</td>
                        <td width="60%" >
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name',$employee->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="38%" >Username</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{ $employee->username }}   
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Email</td>
                        <td width="2%">:</td>
                        <td width="60%">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email',$employee->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror    
                        </td>
                    </tr>                 
                    <tr>
                        <td width="38%" >No. Telp</td>
                        <td width="2%" >:</td>
                        <td width="60%" >
                            <input type="text" class="form-control @error('telp') is-invalid @enderror" id="telp" name="telp" value="{{ old('telp',$employee->telp) }}" required>
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror    
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Ubah Profil</button>
            </div>
        </form>
        </div>              
    </div>
</div>
@endsection