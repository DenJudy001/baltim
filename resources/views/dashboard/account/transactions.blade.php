@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('trx-notice'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <b>Perhatian! </b>{{ session('trx-notice') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('pur-notice'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <b>Perhatian! </b>{{ session('pur-notice') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Catatan Transaksi</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('/transactions') }}" method="get" class="d-inline">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-3 col-lg-2">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" placeholder="Dari">
                            <label for="start_date">Dari</label>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-2">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" placeholder="Dari">
                        <label for="end_date">Sampai</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-2">
                    <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-filter mr-2"></i>Filter</button>
                </div>
            </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">No.</th>
                            <th scope="col" width="20%">Kode Transaksi</th>
                            <th scope="col" width="15%">Tanggal</th>
                            <th scope="col" width="15%">Status</th>
                            <th scope="col" width="30%">Total</th>
                            <th scope="col" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $transaction->purchase_number }}</td>
                                <td>{{ substr($transaction->created_at, 0, 10) }}</td>
                                <td ><span class="badge {{ $transaction->state == 'Proses' ? 'text-bg-warning' : ($transaction->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{ $transaction->state }}</span></td>
                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.')}}</td>
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