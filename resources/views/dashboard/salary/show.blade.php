@extends('dashboard.layouts.main')

@section('container')
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
                        <td width="60%">{{$salary->state}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Tanggal Pembayaran</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$salary->created_at}} (dibuat oleh {{ $salary->responsible }})</td>
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