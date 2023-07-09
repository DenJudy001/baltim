@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/fnb">Daftar Menu</a></li>
            <li class="breadcrumb-item active" aria-current="page">Info Menu</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Menu</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 ">
                <div class="thumbnail text-center">
                    <img src="{{ asset('images/'.$menu->image) }}" class="img-fluid img-thumbnail rounded card-img-top" alt="Gambar Menu" style="width : 80%">
                </div>
            </div>
            <div class="col-md-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Kode Menu</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$menu->code}}</td>
                    </tr>   
                    <tr>
                        <td width="38%">Nama Menu</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$menu->name}}</td>
                    </tr>   
                    <tr>
                        <td width="38%">Keterangan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$menu->description}}</td>
                    </tr>  
                    <tr>
                        <td width="38%">Kategori</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$menu->type}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Harga</td>
                        <td width="2%">:</td>
                        <td width="60%">Rp. {{number_format($menu->price, 0, ',', '.')}}</td>
                    </tr>            
                </table>
            </div>
        </div>              
    </div>
</div>
@endsection