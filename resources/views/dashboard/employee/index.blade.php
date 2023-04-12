@extends('dashboard.layouts.main')

@section('container')

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Daftar Karyawan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="/employee/create" class="btn btn-primary mb-3">Tambah Karyawan</a>
                <table class="table table-striped" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">No.</th>
                            <th scope="col" width="40%">Nama</th>
                            <th scope="col" width="40%">Email</th>
                            <th scope="col" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><div class="d-flex justify-content-evenly">
                                    <a href="/employee/{{ $user->username }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <form action="/employee/{{ $user->username }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection