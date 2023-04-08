@extends('dashboard.layouts.main')

@section('container')
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Akun</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Nama Karyawan</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$employee->name}}</td>
                    </tr>
                    
                    <tr>
                        <td width="38%" >Username</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$employee->username}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Email</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$employee->email}}</td>
                    </tr>                 
                    <tr>
                        <td width="38%" >No. Telp</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$employee->telp}}</td>
                    </tr>
                </table>
            </div>
        </div>              
    </div>
</div>
@endsection