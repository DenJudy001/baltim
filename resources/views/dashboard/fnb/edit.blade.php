@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Menu</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/fnb/{{ $fnb->id }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label @error('name') is-invalid @enderror">Nama
                            Menu</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $fnb->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label @error('description') is-invalid @enderror">Deskripsi
                            Menu</label>
                        <input type="text" class="form-control" id="description" name="description"
                            value="{{ old('description', $fnb->description) }}" required>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label @error('type') is-invalid @enderror">Jenis Menu</label>
                        <select class="form-select single-select-menu-type" data-placeholder="Pilih Jenis Menu"
                            name="type" id="type" required>
                            <option></option>
                            @foreach ($categs as $categ)
                                <option value="{{ $fnb->type }}" @if(old('type', $fnb->type) == $categ->type) selected @endif>{{ $categ->type }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Menu</label>
                        <input type="hidden" name="oldImage" value="{{ $fnb->image }}">
                        @if ($fnb->image)
                            <img src="{{ asset('images/'.$fnb->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
                        @else
                            <img class="img-preview img-fluid mb-3 col-sm-5">
                        @endif
                        <input class="form-control  @error('image') is-invalid @enderror" type="file" id="image"
                            name="image" onchange="previewImage()">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label @error('price') is-invalid @enderror">Harga</label>
                        <input type="number" class="form-control" id="price" name="price"
                            value="{{ old('price', $fnb->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Ubah Menu</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $( '.single-select-menu-type' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                
            } );

            function previewImage() {
                const image = document.querySelector('#image');
                const imgPreview = document.querySelector('.img-preview');
                
                imgPreview.style.display = 'block';
        
                const oFReader = new FileReader();
                oFReader.readAsDataURL(image.files[0]);
        
                oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
                }
            }
            
        });
    </script>
@endpush
