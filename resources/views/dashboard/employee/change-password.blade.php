@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Ubah Kata Sandi Akun</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <form action="/employee-change-password/" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Kata Sandi Lama</td>
                        <td width="2%" >:</td>
                        <td width="60%" >
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" name="old_password" required autofocus>
                            @error('old_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="38%" >Kata Sandi Baru</td>
                        <td width="2%" >:</td>
                        <td width="60%" ><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required> 
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror  
                        </td>
                    </tr>
                    <tr>
                        <td width="38%" >Ulangi Kata Sandi</td>
                        <td width="2%" >:</td>
                        <td width="60%" ><input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" required> 
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror 
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary"><i class="fas fa-pen mr-2"></i>Ubah Kata Sandi</button>
            </div>
        </form>
        </div>              
    </div>
</div>
@endsection