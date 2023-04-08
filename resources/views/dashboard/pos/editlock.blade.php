@extends('dashboard.layouts.main')

@section('container')
@if (isset($announce))
    <div class="alert alert-danger" role="alert">
        <b>Perhatian! </b>
        {{ $announce }}
    </div>
@endif
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $pos->pos_number }}</h4></div>
            @if ($check_menu == True && $pos->state == 'Proses')
                <div class="col text-right" id="changeStatus" data-pos-id="{{ $pos->id }}">
                    <a class="btn btn-success shadow-sm button-finished">{{ __('Selesaikan') }}</a>
                    <a class="btn btn-danger shadow-sm button-cancelled">{{ __('Batalkan') }}</a>
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
                        <td width="60%">{{$pos->created_at}} (dibuat oleh {{ $pos->responsible }})</td>
                    </tr>
                    @if ($pos->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$pos->end_date}}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Status</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$pos->state}}</td>
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

@push('script')
    <script>
        $(document).ready(function(){
            $('#changeStatus').on('click', '.button-finished', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-pos') }}';
                var pos_id = $(this).parents("div").attr("data-pos-id");
                var newStatus = "Selesai";
                if (confirm('Apakah Anda yakin ingin merubah status transaksi?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "pos_id": pos_id,
                            "state": newStatus
                        },
                        success: function (data) {
                            window.location.replace('/account');
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });
            $('#changeStatus').on('click', '.button-cancelled', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-pos') }}';
                var pos_id = $(this).parents("div").attr("data-pos-id");
                var newStatus = "Dibatalkan";
                if (confirm('Apakah Anda yakin ingin merubah status transaksi?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "pos_id": pos_id,
                            "state": newStatus
                        },
                        success: function (data) {
                            window.location.replace('/account');
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
@endpush