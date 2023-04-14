@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/supplier">Daftar Pemasok</a></li>
            <li class="breadcrumb-item active" aria-current="page">Info Pemasok</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Data Pemasok</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Tempat Pemasok</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$supplier->supplier_name}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Keterangan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$supplier->description}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Alamat</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$supplier->address}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Pemilik</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$supplier->responsible}}</td>
                    </tr>
                    <tr>
                        <td width="38%">No.Telp</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$supplier->telp}}</td>
                    </tr>                   
                </table>
            </div>
        </div>              
    </div>
</div>
@if (count($supplier->stuff) != null)
<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Produk</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Menu</th>
                            <th width="60%">Keterangan</th>
                            <th width="15%">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supplier->stuff as $details)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$details->stuff_name}}</td>
                                <td>{{$details->description}}</td>
                                <td>Rp. {{number_format($details->price, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>                               
                </table>
            </div>
        </div>            
    </div>
</div>
@endif
@endsection