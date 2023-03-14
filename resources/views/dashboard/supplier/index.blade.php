@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pemasok Bahan</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-10" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-10">
        <a href="/supplier/create" class="btn btn-primary mb-3">Tambah Pemasok</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">No.Telp</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $loop->iteration }} </td>
                        <td>{{ $supplier->telp }}</td>
                        <td>{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>
                            <a href="/supplier/show" class="badge bg-info"><span data-feather="eye">
                                </span></a>
                            <a href="/supplier/edit" class="badge bg-warning"><span data-feather="edit"> </span></a>
                            <form action="/supplier/" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Are You Sure?')"><span
                                        data-feather="trash"> </span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
