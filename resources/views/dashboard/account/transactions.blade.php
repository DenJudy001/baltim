@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('trx-notice'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <b>Perhatian! </b>{{ session('trx-notice') }} <a href="/transactions?trx=proses">Klik disini!   </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('pur-notice'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <b>Perhatian! </b>{{ session('pur-notice') }} <a href="/transactions?pur=proses">Klik disini!   </a>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col">
                    <h4 class="font-weight-bold">Riwayat Transaksi</h4>
                </div>
                @if (request()->query('pur') == 'proses' || request()->query('trx') == 'proses')
                    <div class="col text-right">
                        <a href="javascript:history.back()" class="btn btn-primary shadow-sm button-finished"><i class="fas fa-arrow-left mr-2"></i></i>{{ __('Kembali') }}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('/transactions') }}" method="get" class="d-inline">
            <div class="row align-items-center">
                <div class="col-sm-12 col-md-3 col-lg-2">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}" placeholder="Dari" required oninvalid="this.setCustomValidity('Tanggal awal tidak boleh kosong!')" oninput="this.setCustomValidity('')">
                            <label for="start_date">Dari</label>
                        </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-2">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}" placeholder="Dari" required oninvalid="this.setCustomValidity('Tanggal akhir tidak boleh kosong!')" oninput="this.setCustomValidity('')">
                        <label for="end_date">Sampai</label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-2">
                    @if (request()->query('pur') == 'proses')
                        <input type="hidden" name="pur" value="proses">
                    @elseif (request()->query('trx') == 'proses')
                        <input type="hidden" name="trx" value="proses">
                    @endif
                    @if (request()->query('start_date'))
                        <button type="button" class="btn btn-danger mb-3" id="resetButton"><i class="fas fa-sync-alt mr-2"></i>Reset</button> 
                    @else
                        <button type="submit" class="btn btn-primary mb-3" id="filterButton"><i class="fas fa-filter mr-2"></i>Filter</button>
                    @endif
                </div>
            </div>
            </form>
            <div class="table-responsive">
                <table class="table" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">No.</th>
                            <th scope="col" width="10%">Status</th>
                            <th scope="col" width="20%">Kode Transaksi</th>
                            <th scope="col" width="20%">Tanggal</th>
                            <th scope="col" width="30%">Total</th>
                            <th scope="col" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td ><span class="badge {{ $transaction->state == 'Proses' ? 'text-bg-warning' : ($transaction->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{ $transaction->state }}</span></td>
                                <td>{{ $transaction->purchase_number }}</td>
                                <td>{{ date('d-m-Y', strtotime($transaction->created_at)) }}</td>
                                <td class="font-weight-bold">Rp. {{ number_format($transaction->total, 0, ',', '.')}}</td>
                                <td>
                                    @if (str_contains($transaction->purchase_number, 'PUR'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/purchase/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/purchase/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <button class="btn btn-danger border-0" onclick="deleteConfirmationPurchase(event, '{{ $transaction->purchase_number }}')"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                    </div>
                                    @elseif (str_contains($transaction->purchase_number, 'SAL'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/salary/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/salary/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <button class="btn btn-danger border-0" onclick="deleteConfirmationSalary(event, '{{ $transaction->purchase_number }}')"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                    </div>
                                    @elseif (str_contains($transaction->purchase_number, 'TRX'))
                                    <div class="d-flex justify-content-evenly">
                                    <a href="/pos/{{ $transaction->purchase_number }}" class="btn btn-info "><i class="fas fa-eye"></i></a>
                                    <a href="/pos/{{ $transaction->purchase_number }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    @can('admin') 
                                    <button class="btn btn-danger border-0" onclick="deleteConfirmationPos(event, '{{ $transaction->purchase_number }}')"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
@push('script')
<script>
    function deleteConfirmationPurchase(event, itemId) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '/purchase/' + itemId,
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        Swal.fire({
                            title:'Terhapus!',
                            text:'Data telah dihapus.',
                            icon:'success',
                            showConfirmButton: false,
                            timer:'1500'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function deleteConfirmationSalary(event, itemId) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '/salary/' + itemId,
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        Swal.fire({
                            title:'Terhapus!',
                            text:'Data telah dihapus.',
                            icon:'success',
                            showConfirmButton: false,
                            timer:'1500'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    function deleteConfirmationPos(event, itemId) {
        event.preventDefault();

        Swal.fire({
            title: 'Apakah Anda yakin ingin menghapus data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: '/pos/' + itemId,
                    data: {
                        _method: 'DELETE',
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        Swal.fire({
                            title:'Terhapus!',
                            text:'Data telah dihapus.',
                            icon:'success',
                            showConfirmButton: false,
                            timer:'1500'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    }
    $(document).ready(function() {
        $("#resetButton").click(function(e) {
            $("#start_date").val('');
            $("#end_date").val('');

            var url = new URL(window.location);
            var params = new URLSearchParams(url.search);
            params.delete('start_date');
            params.delete('end_date');
            var newURL = url.origin + url.pathname + '?' + params.toString();

            window.location.href = newURL;
        });
    });
</script>
    
@endpush