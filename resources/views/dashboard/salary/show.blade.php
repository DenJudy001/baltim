@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Info Gaji Karyawan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $salary->salary_number }}</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Nama Karyawan</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$salary->name}}</td>
                    </tr>
                    <tr>
                        <td width="38%" >No. Telp</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$salary->telp}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Email</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$salary->email}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Status</td>
                        <td width="2%">:</td>
                        <td width="60%"><span class="badge {{ $salary->state == 'Proses' ? 'text-bg-warning' : ($salary->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$salary->state}}</span></td>
                    </tr>
                    <tr>
                        <td width="38%">Tanggal Pencatatan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{date('d-m-Y H:i', strtotime($salary->created_at))}} (dibuat oleh {{ $salary->end_by }})</td>
                    </tr>
                    <tr>
                        <td width="38%" class="font-weight-bold">Jumlah</td>
                        <td width="2%" class="font-weight-bold">:</td>
                        <td width="60%" class="font-weight-bold">Rp. {{number_format($salary->salary, 0, ',', '.')}}</td>
                    </tr>                   
                </table>
            </div>
        </div>              
    </div>
</div>
@endsection