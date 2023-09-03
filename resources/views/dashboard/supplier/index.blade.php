@extends('dashboard.layouts.main')

@section('container')

    @if (session()->has('success'))
        <div class="alert alert-success " role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Daftar Pemasok</h4></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <a href="/supplier/create" class="btn btn-primary mb-3"><i class="fas fa-plus mr-2"></i>Tambah Pemasok</a>
                <table class="table table-striped" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">No.</th>
                            <th scope="col" width="15%">No.Telp</th>
                            <th scope="col" width="20%">Pemasok</th>
                            <th scope="col" width="30%">Alamat</th>
                            <th scope="col" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $supplier->telp }}</td>
                                <td>{{ $supplier->supplier_name }}</td>
                                <td>{{ Str::words($supplier->address, 6) }}</td>
                                <td> <div class="d-flex justify-content-between">
                                    <a href="/supplier/{{ $supplier->id }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="/supplier/{{ $supplier->id }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-danger border-0" onclick="deleteConfirmation(event, {{ $supplier->id }})"><i class="fas fa-trash-alt"></i></button>
                                </div>
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
    function deleteConfirmation(event, itemId) {
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
                    url: '/supplier/' + itemId,
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
</script>
    
@endpush
