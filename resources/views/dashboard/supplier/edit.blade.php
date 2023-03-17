@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Data Pemasok</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/supplier/{{ $supplier->id }}" method="post">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label @error('supplier_name') is-invalid @enderror">Nama
                                Tempat Pemasok</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                value="{{ old('supplier_name',$supplier->supplier_name) }}" required autofocus>
                            @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label @error('description') is-invalid @enderror">Deskripsi
                                Pemasok</label>
                            <input type="text" class="form-control" id="description" name="supplier_description"
                                value="{{ old('supplier_description',$supplier->description) }}" required>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label @error('address') is-invalid @enderror">Alamat
                                Pemasok</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address',$supplier->address) }}" required>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="responsible"
                                class="form-label @error('responsible') is-invalid @enderror">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="responsible" name="responsible"
                                value="{{ old('responsible',$supplier->responsible) }}" required>
                            @error('responsible')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                value="{{ old('telp',$supplier->telp) }}" required>
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        @if(session()->has('error_validate'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error_validate') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="success_hapus">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Bahan</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($stuffs as $stuff)
                                    
                                    <tr>
                                        <td>
                                            <input type="hidden" class="form-control" id="stuff_id" name="stuff_id[]" value="{{ $stuff->id }}">
                                            <input type="text" class="form-control" id="stuff_name" name="stuff_name[]" value="{{ $stuff->stuff_name }}" required>
                                        </td>
                                        <td><input type="text" class="form-control nowrap" id="description" name="description[]" value="{{ $stuff->description }}" required></td>
                                        <td><input type="number" class="form-control" id="price" name="price[]" value="{{ $stuff->price }}" required >
                                            
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" onclick="deleteData('{{ url('/stuff') }}/{{ $stuff->id }}', {{ $stuff->id }})"><span data-feather='trash'></span></a>
                                        </td>
                                    </tr>

                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><a href="javascript:void(0)" class="btn btn-success addRow">Tambah</a></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Selesai</button>
            </form>
        </div>
    </div>
@endsection
