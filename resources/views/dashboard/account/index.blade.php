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
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }} </td>
                        <td>{{ $transaction->purchase_number }}</td>
                        <td>{{ $transaction->total }}</td>
                        <td>{{ $transaction->state }}</td>
                        <td>
                            @if (str_contains($transaction->purchase_number, 'PUR'))
                            <a href="/purchase/{{ $transaction->purchase_number }}" class="badge bg-info"><i class="fas fa-eye"></i></a>
                            <a href="/purchase/{{ $transaction->purchase_number }}/edit" class="badge bg-warning"><i class="fas fa-edit"></i></a>
                            <form action="/purchase/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @elseif (str_contains($transaction->purchase_number, 'SAL'))
                            <a href="/salary/{{ $transaction->purchase_number }}" class="badge bg-info"><i class="fas fa-eye"></i></a>
                            <a href="/salary/{{ $transaction->purchase_number }}/edit" class="badge bg-warning"><i class="fas fa-edit"></i></a>
                            <form action="/salary/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @elseif (str_contains($transaction->purchase_number, 'TRX'))
                            <a href="/pos/{{ $transaction->purchase_number }}" class="badge bg-info"><i class="fas fa-eye"></i></a>
                            <a href="/pos/{{ $transaction->purchase_number }}/edit" class="badge bg-warning"><i class="fas fa-edit"></i></a>
                            <form action="/pos/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
