@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=income&status=pending'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                                Pemasukan Hari Ini (Tertunda)</div>
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
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=income&status=net'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                                Pemasukan Hari Ini (Bersih)</div>
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
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=income&status=all'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                Pemasukan Hari Ini (Total)</div>
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
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=expense&status=pending'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                                Pengeluaran Hari Ini (Tertunda)</div>
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
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=expense&status=net'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                                Pengeluaran Hari Ini (Bersih)</div>
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
                <div class="card-body" style="cursor: pointer" onclick="window.location.href='/transactions-today?type=expense&status=all'">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                Pengeluaran Hari Ini (Total)</div>
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
    
@endsection