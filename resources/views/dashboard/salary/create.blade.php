@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pencatatan Upah Karyawan</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/salary" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="emp_name" class="form-label @error('emp_name') is-invalid @enderror">Nama</label>
                        <select class="form-select single-select-employee" name="user_id" id="emp_name" data-placeholder="Pilih Karyawan" required>
                            <option></option>
                            @foreach ($employee as $emp)
                                @if(old('emp_name') == $emp->id)
                                    <option value="{{ $emp->id }}" selected>{{ $emp->name }}</option>
                                @else
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('emp_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label @error('salary') is-invalid @enderror">Jumlah</label>
                        <input type="hidden" class="form-control" id="name" name="name" value="{{ $emp->name }}">
                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $emp->email }}">
                        <input type="hidden" class="form-control" id="telp" name="telp" value="{{ $emp->telp }}">
                        <input type="number" class="form-control" id="salary" name="salary"
                            value="{{ old('salary') }}" required>
                        @error('salary')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Tambah Upah Karyawan</button>
            </form>
        </div>
    </div>
@endsection
