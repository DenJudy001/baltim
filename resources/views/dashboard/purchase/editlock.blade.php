@extends('dashboard.layouts.main')

@section('container')
@if (count($purchase->dtl_purchase) != null)
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Data Pemesanan</li>
            </ol>
        </nav>
    </div>
    @if (isset($announce))
        <div class="alert alert-danger" role="alert">
            <b>Perhatian! </b>
            {{ $announce }}
        </div>
    @endif
    <div class="card mb-3">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">{{ $purchase->purchase_number }}</h4></div>
                @if ($check_menu == True && $purchase->state == 'Proses')
                    <div class="col text-right" id="changeStatus" data-purchase-id="{{ $purchase->id }}">
                        <a class="btn btn-success shadow-sm button-finished"><i class="fas fa-check mr-2"></i>{{ __('Selesai') }}</a>
                        <a class="btn btn-danger shadow-sm button-cancelled"><i class="fas fa-times mr-2"></i>{{ __('Batal') }}</a>
                    </div>
                @elseif ($purchase->state == 'Selesai')
                    <div class="col text-right" id="reorder" data-supplier-id="{{ $purchase->supplier_id }}" data-purchase-total="{{ $purchase->total }}" data-supplier-name="{{ $purchase->supplier_name }}">
                        <a class="btn btn-primary button-reorder shadow-sm"><i class="fas fa-clone mr-2"></i>Pesan Lagi</a>
                    </div>
                @endif
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
                                <tr class="stuffReorder" data-details-name="{{ $details->name }}" data-details-desc="{{ $details->description }}" data-details-qty="{{ $details->qty }}" data-details-unit="{{ $details->unit }}" data-details-price="{{ $details->price }}">
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
                <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Data Pembayaran</li>
            </ol>
        </nav>
    </div>
    @if (isset($announce))
        <div class="alert alert-danger" role="alert">
            <b>Perhatian! </b>
            {{ $announce }}
        </div>
    @endif
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

@push('script')
    <script>
        $(document).ready(function(){
            $('#changeStatus').on('click', '.button-finished', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Selesai";

                Swal.fire({
                    title: 'Apakah Anda yakin ingin menyelesaikan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1cc88a',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "purchase_id": purchase_id,
                                "state": newStatus
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Berhasil!',
                                    text:'Transaksi telah diselesaikan.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.replace('/transactions');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat merubah status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            $('#changeStatus').on('click', '.button-cancelled', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Dibatalkan";

                Swal.fire({
                    title: 'Apakah Anda yakin ingin membatalkan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "purchase_id": purchase_id,
                                "state": newStatus
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Berhasil!',
                                    text:'Transaksi telah dibatalkan.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.replace('/transactions');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat merubah status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            $('#reorder').on('click', '.button-reorder', function(e){
                e.preventDefault();
                let url = '{{ route('reorder.purchase') }}';
                let supplier_id = $(this).parent("div").attr("data-supplier-id");
                let supplier_name = $(this).parent("div").attr("data-supplier-name");
                let total = $(this).parent("div").attr("data-purchase-total");
                let details = {};
                $('.stuffReorder').each(function() {
                    let name = $(this).data('details-name');
                    let description = $(this).data('details-desc');
                    let qty = $(this).data('details-qty');
                    let unit = $(this).data('details-unit');
                    let price = $(this).data('details-price');
                    details[$(this).index()] = {
                        name: name,
                        description: description,
                        qty: qty,
                        unit: unit,
                        price: price
                    };
                });

                Swal.fire({
                    title: 'Apakah Anda yakin ingin memesan ulang?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1cc88a',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "supplier_id": supplier_id,
                                "supplier_name": supplier_name,
                                "total": total,
                                "details": JSON.stringify(details)
                                
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Berhasil!',
                                    text:'Pesanan berhasil dibuat.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.replace('/transactions');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat memesan ulang.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush