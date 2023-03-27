@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Karyawan Baru</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/employee" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label @error('name') is-invalid @enderror">Nama
                            Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label @error('username') is-invalid @enderror">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP</label>
                        <input type="text" class="form-control" id="telp" name="telp" value="{{ old('telp') }}"
                            required>
                        @error('telp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label @error('password') is-invalid @enderror">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Buat Karyawan</button>
            </form>
        </div>
    </div>
@endsection
