@extends('dashboard.layouts.main')

@section('container')
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
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Buat Laporan Posisi Keuangan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/report/posisi-keuangan-create" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Periode Laporan</h5>
                        <div class="mb-3">
                            <label for="report_year" class="form-label @error('report_year') is-invalid @enderror">Tahun<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="report_year" name="report_year"
                                value="{{ old('report_year') }}" required min="1900" max="2099" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tahun tidak valid !')" oninput="this.setCustomValidity('')">
                            @error('report_year')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="report_periode" class="form-label @error('report_periode') is-invalid @enderror">Periode<span class="text-danger">*</span></label>
                            <select class="form-select single-select-periode" name="report_periode" id="report_periode" data-placeholder="Pilih Bulan" required oninvalid="this.setCustomValidity('Periode tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                                <option></option>
                                <option value="1" @if (old('report_periode') == '1') selected @endif>Januari</option>
                                <option value="2" @if (old('report_periode') == '2') selected @endif>Februari</option>
                                <option value="3" @if (old('report_periode') == '3') selected @endif>Maret</option>
                                <option value="4" @if (old('report_periode') == '4') selected @endif>April</option>
                                <option value="5" @if (old('report_periode') == '5') selected @endif>Mei</option>
                                <option value="6" @if (old('report_periode') == '6') selected @endif>Juni</option>
                                <option value="7" @if (old('report_periode') == '7') selected @endif>Juli</option>
                                <option value="8" @if (old('report_periode') == '8') selected @endif>Agustus</option>
                                <option value="9" @if (old('report_periode') == '9') selected @endif>September</option>
                                <option value="10" @if (old('report_periode') == '10') selected @endif>Oktober</option>
                                <option value="11" @if (old('report_periode') == '11') selected @endif>November</option>
                                <option value="12" @if (old('report_periode') == '12') selected @endif>Desember</option>
                            </select>
                            @error('report_periode')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold">Aset Lancar</h5>
                        <div class="mb-3">
                            <label for="kas" class="form-label @error('kas') is-invalid @enderror">Kas </label>
                            <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jumlah kas yang dipegang saat periode laporan"></i>
                            <input type="number" class="form-control" id="kas" name="kas"
                                value="{{ old('kas',0) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
                            @error('kas')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="piutang" class="form-label @error('piutang') is-invalid @enderror">Piutang </label>
                            <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Jumlah piutang yang dimiliki saat periode laporan"></i>
                            <input type="number" class="form-control" id="piutang" name="piutang"
                                value="{{ old('piutang',0) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
                            @error('piutang')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <p>Persediaan <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Persediaan seperti (bahan makanan, dsb) yang akan digunakan lagi untuk usaha"></i></p>
                        <div class="table-responsive mt-2">
                            <table class="table" id="supplyTable">
                                <thead>
                                    <tr>
                                        <th scope="col" width="50%" nowrap>Nama<span class="text-danger">*</span></th>
                                        <th scope="col" width="40%">Harga<span class="text-danger">*</span></th>
                                        <th scope="col" width="10%">
                                            <div  class="d-flex justify-content-end">
                                                <a href="javascript:void(0)" class="btn btn-success addRowSupply"><i class="fas fa-plus"></i></a>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="supply-table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <h5 class="fw-bold">Aset Tetap</h5>
                    <div class="mb-3 col-md-6">
                        <label for="priceBangunan" class="form-label @error('priceBangunan') is-invalid @enderror">Bangunan </label>
                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Total harga dari aset bangunan yang dimiliki"></i>
                        <input type="number" class="form-control" id="priceBangunan" name="priceBangunan"
                        value="{{ old('priceBangunan',0) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
                        @error('priceBangunan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <p>Non Bangunan <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Aset yang memiliki nilai susut seiring berjalan waktu. Cth:Kendaraan(Motor,Mobil),Peralatan Elektronik, dsb."></i></p>
                    <div class="table-responsive mt-2">
                        <table class="table" id="assetTable">
                            <thead>
                                <tr>
                                    <th scope="col" width="40%" nowrap>Nama<span class="text-danger">*</span></th>
                                    <th scope="col" width="15%" nowrap>Bulan peroleh<span class="text-danger">*</span></th>
                                    <th scope="col" width="10%" nowrap>Tahun peroleh<span class="text-danger">*</span></th>
                                    <th scope="col" width="20%">Harga<span class="text-danger">*</span></th>
                                    <th scope="col" width="5%">
                                        <div  class="d-flex justify-content-end">
                                            <a href="javascript:void(0)" class="btn btn-success addRowAsset"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="asset-table">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-2">
                    <h5 class="fw-bold">Liabilitas</h5>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="utang_usaha" class="form-label @error('utang_usaha') is-invalid @enderror">Utang Usaha</label>
                            <input type="number" class="form-control" id="utang_usaha" name="utang_usaha"
                                value="{{ old('utang_usaha',0) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
                            @error('utang_usaha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="utang_bank" class="form-label @error('utang_bank') is-invalid @enderror">Utang Bank</label>
                            <input type="number" class="form-control" id="utang_bank" name="utang_bank"
                                value="{{ old('utang_bank',0) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
                            @error('utang_bank')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-check mr-2"></i>Simpan Laporan</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        function selectRefresh($sel) {
        $sel.select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            language: {
                "noResults": function(){
                    return "Data Tidak ditemukan";
                }
            }
        });
        }
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
            const now = new Date();
            const year = now.getFullYear();
            var yearInput = $('input#report_year');
            yearInput.val(year);

            function setYearAssetMax($yearAssetInput) {
                const maxYear = yearInput.val();
                $yearAssetInput.attr('max', maxYear);
            }

            $( '.single-select-periode' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                language: {
                    "noResults": function(){
                        return "Data Tidak ditemukan";
                    }
                }
            });

            $('thead').on('click', '.addRowSupply', function(){
                var tr = "<tr>"+
                            "<td>"+
                                "<input type='text' class='form-control supplyID' name='supply_name[]' placeholder='Cth: Ayam utuh 3 Kg' required  oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                            "</td>"+
                            "<td><input type='number' class='form-control priceID' name='supply_price[]' value=0 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRowSupply'><i class='fas fa-trash-alt'></i></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody.supply-table').append(tr);
            });

            $('tbody').on('click', '.deleteRowSupply', function(){
                $(this).parent().parent().remove();
            });

            $('thead').on('click', '.addRowAsset', function(){
                var tr = "<tr>"+
                            "<td>"+
                                "<input type='text' class='form-control nameAsset' name='name_asset[]' placeholder='Cth: Motor vario' required  oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                            "</td>"+
                            "<td><select class='form-select single-select-month-asset' data-placeholder='Pilih Bulan' name='month_asset[]' required oninvalid=\"this.setCustomValidity('Bulan tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                                        "<option></option>"+
                                        "<option value='1'>Januari</option>"+
                                        "<option value='2'>Februari</option>"+
                                        "<option value='3'>Maret</option>"+
                                        "<option value='4'>April</option>"+
                                        "<option value='5'>Mei</option>"+
                                        "<option value='6'>Juni</option>"+
                                        "<option value='7'>Juli</option>"+
                                        "<option value='8'>Agustus</option>"+
                                        "<option value='9'>September</option>"+
                                        "<option value='10'>Oktober</option>"+
                                        "<option value='11'>November</option>"+
                                        "<option value='12'>Desember</option>"+
                                    "</select></td>"+
                            "<td><input type='number' class='form-control yearAsset' name='year_asset[]' placeholder='Cth: 2020' required min='1900' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Tahun tidak valid !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td><input type='number' class='form-control priceAsset' name='price_asset[]' value=0 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRowAsset'><i class='fas fa-trash-alt'></i></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody.asset-table').append(tr);
                var $select_unit = $('.single-select-month-asset').last();
                var $yearAsset = $('.yearAsset').last();
                setYearAssetMax($yearAsset);
                selectRefresh($select_unit);
            });

            $('input#report_year').on('change', function(){
                let $yearAsset = $('.yearAsset');
                setYearAssetMax($yearAsset);
            });

            $('tbody').on('click', '.deleteRowAsset', function(){
                $(this).parent().parent().remove();
            });
        });
    </script>
@endpush
