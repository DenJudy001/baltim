@extends('dashboard.layouts.main')

@section('container')
@if (count($purchase->dtl_purchase) != null)
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                @if(request()->query('today') == 1)
                    <li class="breadcrumb-item"><a href="javascript:history.back()">Kembali</a></li>
                @else
                    <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Info Data Pemesanan</li>
                @endif
            </ol>
        </nav>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">{{ $purchase->purchase_number }}</h4></div>
            </div>                 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Jenis Transaksi</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{$purchase->purchase_name}}</td>
                        </tr>
                        <tr>
                            <td width="38%" >Pemasok</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{$purchase->supplier_name}}</td>
                        </tr>
                        <tr>
                            <td width="38%">Alamat</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->address}}</td>
                        </tr>
                        <tr>
                            <td width="38%">Pemilik</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->supplier_responsible}}</td>
                        </tr>
                        <tr>
                            <td width="38%">No. Telp</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->telp}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%">Status</td>
                            <td width="2%">:</td>
                            <td width="60%"><span class="badge {{ $purchase->state == 'Proses' ? 'text-bg-warning' : ($purchase->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$purchase->state}}</span></td>
                        </tr>
                        <tr>
                            <td width="38%">Tanggal Pemesanan</td>
                            <td width="2%">:</td>
                            <td width="60%">{{date('d-m-Y H:i', strtotime($purchase->created_at))}} (oleh @can('admin') <a href="/employee/{{ $purchase->responsible }}">{{ $purchase->responsible }}</a>@else {{ $purchase->responsible }} @endcan)</td>
                        </tr>
                        @if ($purchase->end_date)
                            <tr>
                                <td width="38%">Tanggal Selesai</td>
                                <td width="2%">:</td>
                                <td width="60%">{{date('d-m-Y H:i', strtotime($purchase->end_date))}} (oleh @can('admin') <a href="/employee/{{ $purchase->end_by }}">{{ $purchase->end_by }}</a>@else {{ $purchase->end_by }} @endcan)</td>
                            </tr>
                        @endif
                        <tr>
                            <td width="38%" class="font-weight-bold">Total</td>
                            <td width="2%" class="font-weight-bold">:</td>
                            <td width="60%" class="font-weight-bold">Rp. {{number_format($purchase->total, 0, ',', '.')}}</td>
                        </tr>                   
                    </table>
                </div>
            </div>              
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Rincian Pemesanan</h4></div>
            </div>                 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table" width="100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="30%">Produk</th>
                                <th width="35%">Keterangan</th>
                                <th width="15%">Jumlah</th>
                                <th width="15%">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->dtl_purchase as $details)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$details->name}}</td>
                                    <td>{{$details->description}}</td>
                                    <td>{{ $details->qty }} {{ $details->unit}}</td>
                                    <td>Rp. {{number_format($details->price, 0, ',', '.')}}</td>
                                </tr>
                            @endforeach
                        </tbody>                               
                    </table>
                </div>
            </div>            
        </div>
    </div>
@else
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                @if(request()->query('today') == 1)
                    <li class="breadcrumb-item"><a href="javascript:history.back()">Kembali</a></li>
                @else
                    <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Info Data Pembayaran</li>
                @endif
            </ol>
        </nav>
    </div>
    <div class="card mb-3">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">{{ $purchase->purchase_number }}</h4></div>
            </div>                 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Jenis Transaksi</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{$purchase->purchase_name}}</td>
                        </tr>
                        <tr>
                            <td width="38%" >Keterangan</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{$purchase->description}}</td>
                        </tr>
                        <tr>
                            <td width="38%">Tanggal Pencatatan</td>
                            <td width="2%">:</td>
                            <td width="60%">{{date('d-m-Y H:i', strtotime($purchase->end_date))}} (oleh @can('admin') <a href="/employee/{{ $purchase->responsible }}">{{ $purchase->responsible }}</a>@else {{ $purchase->responsible }} @endcan)</td>
                        </tr>     
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%">Status</td>
                            <td width="2%">:</td>
                            <td width="60%"><span class="badge {{ $purchase->state == 'Proses' ? 'text-bg-warning' : ($purchase->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$purchase->state}}</span></td>
                        </tr>
                        <tr>
                            <td width="38%" class="font-weight-bold">Total</td>
                            <td width="2%" class="font-weight-bold">:</td>
                            <td width="60%" class="font-weight-bold">Rp. {{number_format($purchase->total, 0, ',', '.')}}</td>
                        </tr>              
                    </table>
                </div>
            </div>              
        </div>
    </div>
@endif
@endsection