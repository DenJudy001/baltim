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
                <a href="/fnb/create" class="btn btn-primary mb-3">Tambah Menu</a>
                <table class="table table-striped table-sm" id="DataTables">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fnbs as $fnb)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>{{ $fnb->name }}</td>
                                <td>{{ $fnb->type }}</td>
                                <td>{{ $fnb->price }}</td>
                                <td>
                                    <a href="/fnb/{{ $fnb->id }}" class="badge bg-info"><i class="fas fa-eye"></i></a>
                                    <a href="/fnb/{{ $fnb->id }}/edit" class="badge bg-warning"><i class="fas fa-edit"></i></a>
                                    <form action="/fnb/{{ $fnb->id }}" method="POST" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="badge bg-danger border-0" onclick="return confirm('Apakah Anda yakin ingin menghapus data?')"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
