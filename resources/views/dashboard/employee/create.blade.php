@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                <li class="breadcrumb-item"><a href="/employee">Daftar Karyawan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Karyawan</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Tambah Karyawan Baru</h4></div>
            </div> 
        </div>
        <div class="card-body">
            <form action="/employee" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label @error('name') is-invalid @enderror">Nama
                            Lengkap<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required autofocus oninvalid="this.setCustomValidity('Nama tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label @error('username') is-invalid @enderror">Username<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required oninvalid="this.setCustomValidity('Username tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP<span class="text-danger">*</span> Cth: 62878***</label>
                            <input type="text" class="form-control" id="telp" name="telp" value="{{ old('telp') }}"
                                required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Nomor telepon tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label @error('email') is-invalid @enderror">Email<span class="text-danger">*</span> <span>Cth: xxx@gmail.com</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                                required oninvalid="this.setCustomValidity('Email tidak valid !')" oninput="this.setCustomValidity('')">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label @error('password') is-invalid @enderror">Kata sandi<span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required oninvalid="this.setCustomValidity('Kata sandi tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>                  
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-users mr-2"></i>Buat Karyawan</button>
            </form>
        </div>
    </div>
@endsection
