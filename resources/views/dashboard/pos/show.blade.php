@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            @if(request()->query('today') == 1)
                <li class="breadcrumb-item"><a href="javascript:history.back()">Kembali</a></li>
            @else
                <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Info Data Penjualan</li>
            @endif
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $pos->pos_number }}</h4></div>
            @if ($pos->state == 'Selesai')
                <div class="col text-right">
                    <a href="/pos/{{ $pos->pos_number }}/print_struk" target="_blank" class="btn btn-success shadow-sm"><i class="fas fa-print mr-2"></i>Cetak</a>
                </div>
            @endif
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Tanggal Penjualan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{date('d-m-Y H:i', strtotime($pos->created_at))}} (oleh @can('admin') <a href="/employee/{{ $pos->responsible }}">{{ $pos->responsible }}</a>@else {{ $pos->responsible }} @endcan)</td>
                    </tr>
                    @if ($pos->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{date('d-m-Y H:i', strtotime($pos->end_date))}} (oleh @can('admin') <a href="/employee/{{ $pos->end_by }}">{{ $pos->end_by }}</a>@else {{ $pos->end_by }} @endcan)</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Status</td>
                        <td width="2%">:</td>
                        <td width="60%" ><span class="badge {{ $pos->state == 'Proses' ? 'text-bg-warning' : ($pos->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$pos->state}}</span></td>
                    </tr>
                    <tr>
                        <td width="38%" class="font-weight-bold">Total</td>
                        <td width="2%" class="font-weight-bold">:</td>
                        <td width="60%" class="font-weight-bold">Rp. {{number_format($pos->total, 0, ',', '.')}}</td>
                    </tr>                   
                </table>
            </div>
        </div>              
    </div>
</div>
<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Penjualan</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Menu</th>
                            <th width="35%">Keterangan</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Jumlah</th>
                            <th width="20%">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pos->dtl_pos as $details)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$details->name}}</td>
                                <td>{{$details->description}}</td>
                                <td>{{$details->type}}</td>
                                <td>{{ $details->qty }}</td>
                                <td>Rp. {{number_format($details->price, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>                               
                </table>
            </div>
        </div>            
    </div>
</div>
@endsection