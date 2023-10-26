@extends('dashboard.layouts.main')

@section('container')
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Daftar Menu</h4></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="/fnb/create" class="btn btn-primary mb-3"><i class="fas fa-plus mr-2"></i>Tambah Menu</a>
                <table class="table" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col" width="5%">No.</th>
                            <th scope="col" width="10%">Kode</th>
                            <th scope="col" width="30%">Nama</th>
                            <th scope="col" width="20%">Jenis</th>
                            <th scope="col" width="20%">Harga</th>
                            <th scope="col" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fnbs as $fnb)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $fnb->code }}</td>
                                <td>{{ $fnb->name }}</td>
                                <td>{{ $fnb->type }}</td>
                                <td>Rp. {{ number_format($fnb->price, 0, ',', '.')}}</td>
                                <td><div class="d-flex justify-content-between">
                                    <a href="/fnb/{{ $fnb->id }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="/fnb/{{ $fnb->id }}/edit" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                    <button class="btn btn-danger border-0" onclick="deleteConfirmation(event, {{ $fnb->id }})"><i class="fas fa-trash-alt"></i></button>
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
                    url: '/fnb/' + itemId,
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
