@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Laporan Laba Rugi</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/report/laba-rugi-download" method="post" target="_blank">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="year" class="form-label @error('year') is-invalid @enderror">Tahun<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="year" name="year"
                            value="{{ old('year') }}" required min="1900" max="2099" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tahun tidak valid !')" oninput="this.setCustomValidity('')">
                        @error('year')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="periode" class="form-label @error('periode') is-invalid @enderror">Periode<span class="text-danger">*</span></label>
                        <select class="form-select single-select-periode" name="periode" id="periode" data-placeholder="Pilih Bulan" required oninvalid="this.setCustomValidity('Periode tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            <option></option>
                            <option value="1" @if (old('periode') == '1') selected @endif>Januari</option>
                            <option value="2" @if (old('periode') == '2') selected @endif>Februari</option>
                            <option value="3" @if (old('periode') == '3') selected @endif>Maret</option>
                            <option value="4" @if (old('periode') == '4') selected @endif>April</option>
                            <option value="5" @if (old('periode') == '5') selected @endif>Mei</option>
                            <option value="6" @if (old('periode') == '6') selected @endif>Juni</option>
                            <option value="7" @if (old('periode') == '7') selected @endif>Juli</option>
                            <option value="8" @if (old('periode') == '8') selected @endif>Agustus</option>
                            <option value="9" @if (old('periode') == '9') selected @endif>September</option>
                            <option value="10" @if (old('periode') == '10') selected @endif>Oktober</option>
                            <option value="11" @if (old('periode') == '11') selected @endif>November</option>
                            <option value="12" @if (old('periode') == '12') selected @endif>Desember</option>
                        </select>
                        @error('periode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-eye mr-2"></i></i>Lihat Laporan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $( '.single-select-periode' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                language: {
                    "noResults": function(){
                        return "Data Tidak ditemukan";
                    }
                }
            } );

            const now = new Date();
            const year = now.getFullYear();
            var yearInput = $('input#year');
            yearInput.val(year);
            
        });
    </script>
@endpush
