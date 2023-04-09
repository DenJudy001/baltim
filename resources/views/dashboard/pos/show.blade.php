@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/account">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Info Data Penjualan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $pos->pos_number }}</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Tanggal Penjualan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$pos->created_at}} (oleh {{ $pos->responsible }})</td>
                    </tr>
                    @if ($pos->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$pos->end_date}} (oleh {{ $pos->end_by }})</td>
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
            <div class="col-sm-12">
                <table class="table table-sm" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pos->dtl_pos as $details)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$details->name}}</td>
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