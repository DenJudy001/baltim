@extends('dashboard.layouts.main')

@section('container')
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Laporan Posisi Keuangan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">Periode Laporan</h5>
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Tahun</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{$report->report_year}}</td>
                        </tr>
                        <tr>
                            <td width="38%" >Periode</td>
                            <td width="2%" >:</td>
                            <td width="60%" >{{ strftime('%B', mktime(0, 0, 0, $report->report_periode, 1, 2023)) }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold">Aset Lancar</h5>
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Kas</td>
                            <td width="2%" >:</td>
                            <td width="60%" >Rp. {{number_format($report->kas, 0, ',', '.')}}</td>
                        </tr>
                        <tr>
                            <td width="38%" >Piutang</td>
                            <td width="2%" >:</td>
                            <td width="60%" >Rp. {{number_format($report->piutang, 0, ',', '.')}}</td>
                        </tr>
                    </table>
                    <p>Persediaan</p>
                    <div class="table-responsive mt-2">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" width="5%">No.</th>
                                    <th scope="col" width="50%" nowrap>Nama</th>
                                    <th scope="col" width="45%">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($report->dtl_reports->where('type', 'Persediaan') as $details)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$details->name}}</td>
                                        <td>Rp. {{number_format($details->price, 0, ',', '.')}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak memiliki data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <h5 class="fw-bold">Aset Tetap</h5>
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="18%" >Bangunan</td>
                        <td width="2%" >:</td>
                        <td width="80%" >Rp. {{number_format($report->dtl_reports->where('type','Asset Bangunan')->first()->price ?? 0, 0, ',', '.')}}</td>
                    </tr>
                </table>
                <p>Non Bangunan</p>
                <div class="table-responsive mt-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" width="5%">No.</th>
                                <th scope="col" width="40%" nowrap>Nama</th>
                                <th scope="col" width="15%" >Bulan peroleh</th>
                                <th scope="col" width="18%" >Tahun peroleh</th>
                                <th scope="col" width="22%">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($report->dtl_reports->where('type', 'Asset') as $details)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$details->name}}</td>
                                    <td>{{$details->month_asset}}</td>
                                    <td>{{$details->year_asset}}</td>
                                    <td>Rp. {{number_format($details->price, 0, ',', '.')}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak memiliki data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <h5 class="fw-bold">Liabilitas</h5>
                <div class="col-md-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Utang Usaha</td>
                            <td width="2%" >:</td>
                            <td width="60%" >Rp. {{number_format($report->utang_usaha, 0, ',', '.')}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table width="100%" class="table table-borderless">
                        <tr>
                            <td width="38%" >Utang Bank</td>
                            <td width="2%" >:</td>
                            <td width="60%" >Rp. {{number_format($report->utang_bank, 0, ',', '.')}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <a href="/report/posisi-keuangan/{{ $report->id }}/edit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-pen mr-2"></i>Ubah Laporan</a>
            <form action="/report/posisi-keuangan-download/{{ $report->id }}" method="post" target="_blank" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-eye mr-2"></i>Lihat Laporan</button>
            </form>
        </div>
    </div>
@endsection