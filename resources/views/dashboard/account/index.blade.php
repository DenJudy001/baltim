@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pencatatan Transaksi</h1>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success col-lg-10" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive col-lg-10">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kode Transaksi</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase as $purch)
                    <tr>
                        <td>{{ $loop->iteration }} </td>
                        <td>{{ $purch->purchase_number }}</td>
                        <td>{{ $purch->total }}</td>
                        <td>{{ $purch->state }}</td>
                        <td>
                            <a href="/purchase/show" class="badge bg-info"><span data-feather="eye">
                                </span></a>
                            <a href="/purchase/{{ $purch->purchase_number }}/edit" class="badge bg-warning"><span data-feather="edit"> </span></a>
                            <form action="/purchase/{{ $purch->purchase_number }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><span
                                        data-feather="trash"> </span></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
