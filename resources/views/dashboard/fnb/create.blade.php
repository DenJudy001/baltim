@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                <li class="breadcrumb-item"><a href="/fnb">Daftar Menu</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Menu</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Tambah Menu Baru</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/fnb" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Menu</label>
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                            <input class="form-control  @error('image') is-invalid @enderror" type="file" id="image"
                                name="image" placeholder="Pilih Gambar">
                            @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code" class="form-label @error('code') is-invalid @enderror">Kode Menu<span class="text-danger">*</span></label><i class="fas fa-question-circle ml-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Untuk mempermudah pencarian menu (3-5 karakter)"></i>
                            <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" placeholder="Cth: AA001"
                                required autofocus oninvalid="this.setCustomValidity('Kode menu tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label @error('name') is-invalid @enderror">Nama
                                Menu<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Cth: Ayam Bakar"
                                required autofocus oninvalid="this.setCustomValidity('Nama tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label @error('description') is-invalid @enderror">Keterangan
                                </label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Cth : 1 potong ayam">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label @error('type') is-invalid @enderror">Jenis Menu<span class="text-danger">*</span></label>
                            <select class="form-select single-select-menu-type" data-placeholder="Pilih Jenis Menu"
                                name="type" id="type" required oninvalid="this.setCustomValidity('Kategori tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                                <option></option>
                                @foreach ( $categs as $categ )
                                    <option value="{{ $categ->type }}" {{ old('type') == $categ->type ? 'selected' : '' }}>{{ $categ->type }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label @error('price') is-invalid @enderror">Harga<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Cth: 15000"
                            min="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required oninvalid="this.setCustomValidity('Harga tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-utensils mr-2"></i>Buat Menu</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
            $( '.single-select-menu-type' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                tags : true
            } );

            $("#image").change(function() {
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');
                
                imgPreview.style.display = 'block';
        
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);
        
                oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
                }
            });
            
        });
    </script>
@endpush
