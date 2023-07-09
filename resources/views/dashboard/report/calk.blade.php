@extends('dashboard.layouts.main')

@section('container')
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <b>Perhatian!</b> Catatan Atas Laporan Keuangan membutuhkan Laporan Posisi Keuangan dan Laba Rugi.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <b>Tips!</b> Pastikan sudah menyimpan data Laporan Posisi Keuangan.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Catatan Atas Laporan Keuangan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/report/calk-download/{{ $periode->id ?? '' }}" method="post" target="_blank">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="periode" class="form-label @error('periode') is-invalid @enderror">Periode<span class="text-danger">*</span></label>
                        <select class="form-select single-select-periode" name="periode" id="periode" data-placeholder="Pilih Bulan" required oninvalid="this.setCustomValidity('Periode tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            <option></option>
                            @if ($periode)
                                <option value="{{ $periode->report_periode ?? ''}}">{{ strftime('%B', mktime(0, 0, 0, $periode->report_periode, 1, 2023)) }}</option>
                            @endif

                        </select>
                        @error('periode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label @error('year') is-invalid @enderror">Tahun<span class="text-danger">*</span></label>
                        <input type="number" class="form-control-plaintext" id="year" name="year" readonly value="{{ old('year',0) }}" required oninvalid="this.setCustomValidity('Tahun tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('year')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-download mr-2"></i>Unduh Laporan</button>
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

            $("#periode").change(function(){
                var month = $(this).val();
                var year = 'input#year';
                $(year).val({{ $periode->report_year ?? '' }});
            });
            
        });
    </script>
@endpush
