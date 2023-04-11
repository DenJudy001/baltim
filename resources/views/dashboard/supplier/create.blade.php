@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                <li class="breadcrumb-item"><a href="/supplier">Daftar Pemasok</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Pemasok</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Tambah Pemasok Baru</h4></div>
            </div> 
        </div>
        <div class="card-body">
            <form action="/supplier" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label @error('supplier_name') is-invalid @enderror">Nama
                                Tempat Pemasok<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                value="{{ old('supplier_name') }}" required autofocus oninvalid="this.setCustomValidity('Nama Tempat Pemasok tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label @error('description') is-invalid @enderror">Keterangan</label>
                            <textarea type="text" class="form-control" id="description" name="supplier_description"
                                >{{ old('supplier_description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label @error('address') is-invalid @enderror">Alamat<span class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" id="address" name="address"
                                required oninvalid="this.setCustomValidity('Alamat tidak boleh kosong !')" oninput="this.setCustomValidity('')">{{ old('address') }}</textarea>
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
                                class="form-label @error('responsible') is-invalid @enderror">Pemilik<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="responsible" name="responsible"
                                value="{{ old('responsible') }}" required oninvalid="this.setCustomValidity('Nama Pemilik tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('responsible')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP<span class="text-danger">*</span> Cth: 62878***</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                value="{{ old('telp') }}" required oninvalid="this.setCustomValidity('Nomor Telepon tidak boleh kosong !')" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.setCustomValidity('')">
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
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error_validate ) 
                                        <li>
                                            {{ $error_validate }}
                                        </li>
                                    @endforeach
                                    @if(session()->has('error_validate'))
                                        <li>
                                            {{ session('error_validate') }}
                                        </li>
                                    @endif
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if(session()->has('error_unique'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @if(session()->has('error_unique'))
                                    <li>
                                        {{ session('error_unique') }}
                                    </li>
                                @endif
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Bahan<span class="text-danger">*</span></th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Harga<span class="text-danger">*</span></th>
                                    <th scope="col"><a href="javascript:void(0)" class="btn btn-success addRow">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('thead').on('click', '.addRow', function(){
                var tr = "<tr>"+
                            "<td><input type='text' class='form-control' name='stuff_name[]' required oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td><textarea class='form-control' name='description[]' ></textarea></td>"+
                            "<td><input type='number' class='form-control' name='price[]' value='1' required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRow'><i class='fas fa-trash-alt'></i></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody').append(tr);
                // feather.replace();
            });

            $('tbody').on('click', '.deleteRow', function(){
                $(this).parent().parent().remove();
            });
        });
    </script>
@endpush
