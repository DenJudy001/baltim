@extends('dashboard.layouts.main')

@section('container')
@if (count($purchase->dtl_purchase) != null)
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
                            <td width="60%">{{$purchase->state}}</td>
                        </tr>
                        <tr>
                            <td width="38%">Tanggal pemesanan</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->created_at}} (dibuat oleh {{ $purchase->responsible }})</td>
                        </tr>
                        @if ($purchase->end_date)
                            <tr>
                                <td width="38%">Tanggal Selesai</td>
                                <td width="2%">:</td>
                                <td width="60%">{{$purchase->end_date}}</td>
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
                <div class="col"><h4 class="font-weight-bold">Rincian Pembelian</h4></div>
            </div>                 
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
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
                            <td width="38%">Tanggal pemesanan</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->created_at}} (dibuat oleh {{ $purchase->responsible }})</td>
                        </tr>
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->end_date}}</td>
                        </tr>     
                    </table>
                </div>
                <div class="col-sm-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%">Status</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->state}}</td>
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