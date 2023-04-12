@extends('dashboard.layouts.main')

@section('container')
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                                Pemasukan (Tertunda)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($pendingIncome, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan (Bersih)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($confirmedIncome, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                Pemasukan (Total)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($totalIncome, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                                Pengeluaran (Tertunda)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($pendingExpense, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                                Pengeluaran (Bersih)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($confirmedExpense, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                Pengeluaran (Total)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. {{number_format($totalExpense, 0, ',', '.')}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Catatan Transaksi</h4></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">Np.</th>
                            <th scope="col" width="35%">Kode Transaksi</th>
                            <th scope="col" width="30%">Total</th>
                            <th scope="col" width="15%">Status</th>
                            <th scope="col" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $transaction->purchase_number }}</td>
                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.')}}</td>
                                <td ><span class="badge {{ $transaction->state == 'Proses' ? 'text-bg-warning' : ($transaction->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{ $transaction->state }}</span></td>
                                <td>
                                    @if (str_contains($transaction->purchase_number, 'PUR'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/purchase/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/purchase/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <form action="/purchase/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    @endcan
                                    </div>
                                    @elseif (str_contains($transaction->purchase_number, 'SAL'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/salary/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/salary/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <form action="/salary/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    @endcan
                                    </div>
                                    @elseif (str_contains($transaction->purchase_number, 'TRX'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/pos/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/pos/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <form action="/pos/{{ $transaction->purchase_number }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                    @endcan
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection