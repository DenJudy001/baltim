@extends('dashboard.layouts.main')

@section('container')
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <b>Tips!</b> Pastikan klik Simpan Laporan sebelum mengubah <b>Persediaan</b> atau <b>Aset Non-Bangunan</b>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Ubah Laporan Posisi Keuangan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/report/posisi-keuangan-update/{{ $report->id }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="fw-bold">Periode Laporan</h5>
                        <div class="mb-3">
                            <label for="report_year" class="form-label @error('report_year') is-invalid @enderror">Tahun<span class="text-danger">*</span></label>
                            @php
                                $minYearAsset = $report->dtl_reports->where('type', 'Asset')->max('year_asset');
                            @endphp
                            <input type="number" class="form-control" id="report_year" name="report_year"
                                value="{{ old('report_year',$report->report_year) }}" required min={{ $minYearAsset ?? 1900 }} max="2099" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tahun tidak valid atau cek tahun peroleh aset non-bangunan !')" oninput="this.setCustomValidity('')">
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
                                <option value="1" @if (old('report_periode',$report->report_periode) == '1') selected @endif>Januari</option>
                                <option value="2" @if (old('report_periode',$report->report_periode) == '2') selected @endif>Februari</option>
                                <option value="3" @if (old('report_periode',$report->report_periode) == '3') selected @endif>Maret</option>
                                <option value="4" @if (old('report_periode',$report->report_periode) == '4') selected @endif>April</option>
                                <option value="5" @if (old('report_periode',$report->report_periode) == '5') selected @endif>Mei</option>
                                <option value="6" @if (old('report_periode',$report->report_periode) == '6') selected @endif>Juni</option>
                                <option value="7" @if (old('report_periode',$report->report_periode) == '7') selected @endif>Juli</option>
                                <option value="8" @if (old('report_periode',$report->report_periode) == '8') selected @endif>Agustus</option>
                                <option value="9" @if (old('report_periode',$report->report_periode) == '9') selected @endif>September</option>
                                <option value="10" @if (old('report_periode',$report->report_periode) == '10') selected @endif>Oktober</option>
                                <option value="11" @if (old('report_periode',$report->report_periode) == '11') selected @endif>November</option>
                                <option value="12" @if (old('report_periode',$report->report_periode) == '12') selected @endif>Desember</option>
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
                                value="{{ old('kas',$report->kas) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
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
                                value="{{ old('piutang',$report->piutang) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
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
                                        <th scope="col" width="40%" nowrap>Nama<span class="text-danger">*</span></th>
                                        <th scope="col" width="40%">Harga<span class="text-danger">*</span></th>
                                        <th scope="col" width="20%">
                                            <div  class="d-flex justify-content-end">
                                                <a href="javascript:void(0)" class="btn btn-success addRowSupply"><i class="fas fa-plus"></i></a>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="supply-table">
                                    @foreach ($report->dtl_reports->where('type', 'Persediaan') as $details)
                                        <tr data-id="{{ $details->id }}" data-report-id="{{ $report->id }}">
                                            <td>
                                                <input type='text' class='form-control-plaintext supplyID' name='name' required value="{{ old('name',$details->name) }}" aria-describedby="inputGroupPrepend3 validationServerSupplyFeedback" readonly>
                                                <div id='validationServerSupplyFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control-plaintext priceIDFormat" value="Rp. {{ number_format($details->price, 0, ',', '.') }}" readonly>
                                                <input type='hidden' class='form-control-plaintext priceID' name='price' value={{ old('price',$details->price) }} required readonly min='1' >
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <a class="btn btn-success button-save d-none col-sm-6 mr-1" ><i class="fas fa-check"></i></a>
                                                    <a class="btn btn-warning button-edit col-sm-6 mr-1"><i class="fas fa-edit"></i></a>
                                                    <a class="btn btn-danger button-cancel d-none col-sm-6"><i class="fas fa-times"></i></a>
                                                    <a class="btn btn-danger single-stuff col-sm-6"><i class="fas fa-trash-alt"></i></a>
                                                </div>
                                            </td>
                                        </tr>                                        
                                    @endforeach
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
                        value="{{ old('priceBangunan', $report->dtl_reports->where('type','Asset Bangunan')->first()->price ?? '0') }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
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
                                @foreach ($report->dtl_reports->where('type', 'Asset') as $details)
                                <tr data-id="{{ $details->id }}" data-report-id="{{ $report->id }}">
                                    <td>
                                        <input type='text' class='form-control-plaintext nameAsset' name='name' required value="{{ old('name',$details->name) }}" aria-describedby="inputGroupPrepend3 validationServerAssetFeedback" readonly>
                                        <div id='validationServerAssetFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>
                                    </td>
                                    <td>
                                        <select class="form-select single-select-month-asset monthAsset" data-placeholder="Pilih Bulan" name="month_asset" required disabled>
                                            <option></option>
                                            <option value="1" @if (old('month_asset',$details->month_asset) == '1') selected @endif>Januari</option>
                                            <option value="2" @if (old('month_asset',$details->month_asset) == '2') selected @endif>Februari</option>
                                            <option value="3" @if (old('month_asset',$details->month_asset) == '3') selected @endif>Maret</option>
                                            <option value="4" @if (old('month_asset',$details->month_asset) == '4') selected @endif>April</option>
                                            <option value="5" @if (old('month_asset',$details->month_asset) == '5') selected @endif>Mei</option>
                                            <option value="6" @if (old('month_asset',$details->month_asset) == '6') selected @endif>Juni</option>
                                            <option value="7" @if (old('month_asset',$details->month_asset) == '7') selected @endif>Juli</option>
                                            <option value="8" @if (old('month_asset',$details->month_asset) == '8') selected @endif>Agustus</option>
                                            <option value="9" @if (old('month_asset',$details->month_asset) == '9') selected @endif>September</option>
                                            <option value="10" @if (old('month_asset',$details->month_asset) == '10') selected @endif>Oktober</option>
                                            <option value="11" @if (old('month_asset',$details->month_asset) == '11') selected @endif>November</option>
                                            <option value="12" @if (old('month_asset',$details->month_asset) == '12') selected @endif>Desember</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type='number' class='form-control-plaintext yearAsset' name='year_asset' value={{ old('year_asset',$details->year_asset) }} required readonly min='1900' >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control-plaintext priceAssetFormat" value="Rp. {{ number_format($details->price, 0, ',', '.') }}" readonly>
                                        <input type='hidden' class='form-control-plaintext priceAsset' name='price' value={{ old('price',$details->price) }} required readonly min='1' >
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <a class="btn btn-success button-save2 d-none col-sm-6 mr-1" ><i class="fas fa-check"></i></a>
                                            <a class="btn btn-warning button-edit2 col-sm-6 mr-1"><i class="fas fa-edit"></i></a>
                                            <a class="btn btn-danger button-cancel2 d-none col-sm-6"><i class="fas fa-times"></i></a>
                                            <a class="btn btn-danger single-stuff2 col-sm-6"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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
                                value="{{ old('utang_usaha',$report->utang_usaha) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
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
                                value="{{ old('utang_bank',$report->utang_bank) }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Tulis 0 jika kosong !')" oninput="this.setCustomValidity('')">
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
            var yearInput = $('input#report_year');
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
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('input.supplyID');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerSupplyFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerSupply');
                    errorMSG.removeClass('d-none');
                }
                else{
                    var tr = "<tr data-report-id='{{ $report->id }}'>"+
                                "<td>"+
                                    "<input type='text' class='form-control supplyID' name='name' required oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\" aria-describedby='inputGroupPrepend3 validationServerSupplyFeedback' >"+
                                    "<div id='validationServerSupplyFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>"+
                                "</td>"+
                                "<td><input type='number' class='form-control priceID' name='price' value=0 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                                "<td>"+
                                    "<div class='d-flex justify-content-between'>"+
                                    "<a class='btn btn-success button-save col-sm-6 mr-1'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit d-none col-sm-6'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel d-none col-sm-6'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger col-sm-6 deleteRowSupply'><i class='fas fa-trash-alt'></i></a>"+
                                    "</div>"+
                                "</td>"+
                            "</tr>"
                    $('tbody.supply-table').append(tr);
                }
            });

            $('tbody').on('click', '.deleteRowSupply', function(){
                $(this).parent().parent().parent().remove();
            });

            $('thead').on('click', '.addRowAsset', function(){
                var editButtonLoc = $('.button-edit2');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit2.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('input.nameAsset');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerAssetFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerAsset');
                    errorMSG.removeClass('d-none');
                }
                else{
                    var tr = "<tr data-report-id='{{ $report->id }}'>"+
                                "<td>"+
                                    "<input type='text' class='form-control nameAsset' name='name' required aria-describedby='inputGroupPrepend3 validationServerAssetFeedback' oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                                    "<div id='validationServerAssetFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>"+
                                "</td>"+
                                "<td><select class='form-select single-select-month-asset monthAsset' data-placeholder='Pilih Bulan' name='month_asset' required oninvalid=\"this.setCustomValidity('Bulan tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
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
                                "<td><input type='number' class='form-control yearAsset' name='year_asset' required min='1900' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Tahun tidak valid !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                                "<td><input type='number' class='form-control priceAsset' name='price' value=0 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                                "<td>"+
                                    "<div class='d-flex justify-content-between'>"+
                                    "<a class='btn btn-success button-save2 col-sm-6 mr-1'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit2 d-none col-sm-6'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel2 d-none col-sm-6'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger col-sm-6 deleteRowAsset'><i class='fas fa-trash-alt'></i></a>"+
                                    "</div>"+
                                "</td>"+
                            "</tr>"
                    $('tbody.asset-table').append(tr);
                    var $select_unit = $('.single-select-month-asset').last();
                    var $yearAsset = $('.yearAsset').last();
                    setYearAssetMax($yearAsset);
                    selectRefresh($select_unit);
                }
            });

            $('input#report_year').on('change', function(){
                let $yearAsset = $('.yearAsset');
                setYearAssetMax($yearAsset);
            });

            $('tbody').on('click', '.deleteRowAsset', function(){
                $(this).parent().parent().parent().remove();
            });

            $('#supplyTable').on('click', '.button-edit', function(){
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('input.supplyID');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerSupplyFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerSupply');
                    errorMSG.removeClass('d-none');
                } else{
                    var saveButton = $(this).closest('td').find('a.button-save');
                    var editButton = $(this);
                    var cancelButton = $(this).closest('td').find('a.button-cancel');
                    var deleteButton = $(this).closest('td').find('a.single-stuff');
                    var inpName = editButton.closest('tr').find('input.supplyID');
                    var inpPrice = editButton.closest('tr').find('input.priceID');
                    var inpPriceFormat = editButton.closest('tr').find('input.priceIDFormat');

                    inpName.removeClass('form-control-plaintext');
                    inpName.removeAttr("readonly");
                    inpName.addClass('form-control');
                    inpPrice.removeClass('form-control-plaintext');
                    inpPrice.removeAttr("readonly");
                    inpPrice.addClass('form-control');
                    inpPrice.attr('type','number');
                    inpPriceFormat.attr('type','hidden');

                    saveButton.removeClass('d-none');
                    cancelButton.removeClass('d-none');
                    editButton.addClass('d-none');
                    deleteButton.addClass('d-none');
                }
            });

            $('#supplyTable').on('click', '.button-save', function(e){
                e.preventDefault();

                var saveButton = $(this);
                var inpName = saveButton.closest('tr').find('input.supplyID');
                var inpPrice = saveButton.closest('tr').find('input.priceID');
                var value_name = inpName.val();
                var value_price = parseInt(inpPrice.val());
                var id = saveButton.parents("tr").attr("data-id");
                var report_id = saveButton.parents("tr").attr("data-report-id");
                
                $.ajax({
                    url: '{{ route('update.details-report') }}',
                    type: "post",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "report_id": report_id,
                        "name" : value_name,
                        "price" : value_price,
                        "type" : 'Persediaan'
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(response) {
                        let keyname;
                        let keymessage;
                        // console.log('Sekarang error')
                        $.each(response.responseJSON.errors, function(key, value){
                            keyname = key;
                            keymessage = value;
                        });
                        // console.log(response.responseJSON);
                        inpName.closest('td').find('.invalid-feedback').empty();
                        inpName.removeClass('is-invalid');
                        inpPrice.closest('td').find('.invalid-feedback').empty();
                        inpPrice.removeClass('is-invalid');
                        if (keyname == inpName.attr('name')){
                            inpName.addClass('is-invalid');
                            inpName.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == inpPrice.attr('name')){
                            inpPrice.addClass('is-invalid');
                            inpPrice.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        
                    }
                });

            });

            $('#supplyTable').on('click', '.button-cancel', function(e){
                e.preventDefault();
                window.location.reload();
            });

            $('#supplyTable').on('click', '.single-stuff', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var url = `{{ url('/detail-report/${id}') }}`;

                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": id,
                        },
                        success: function (data) {
                             window.location.reload();
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });

            $('#assetTable').on('click', '.button-edit2', function(){
                var editButtonLoc = $('.button-edit2');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit2.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('input.nameAsset');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerAssetFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerAsset');
                    errorMSG.removeClass('d-none');
                } else{
                    var saveButton = $(this).closest('td').find('a.button-save2');
                    var editButton = $(this);
                    var cancelButton = $(this).closest('td').find('a.button-cancel2');
                    var deleteButton = $(this).closest('td').find('a.single-stuff2');
                    var inpName = editButton.closest('tr').find('input.nameAsset');
                    var inpPrice = editButton.closest('tr').find('input.priceAsset');
                    var inpqty = editButton.closest('tr').find('input.yearAsset');
                    var inpunit = editButton.closest('tr').find('select.monthAsset');
                    var inpPriceFormat = editButton.closest('tr').find('input.priceAssetFormat');

                    inpName.removeClass('form-control-plaintext');
                    inpName.removeAttr("readonly");
                    inpName.addClass('form-control');
                    inpPrice.removeClass('form-control-plaintext');
                    inpPrice.removeAttr("readonly");
                    inpPrice.addClass('form-control');
                    inpPrice.attr('type','number');
                    inpPriceFormat.attr('type','hidden');

                    inpunit.removeAttr("disabled");
                    inpqty.removeClass('form-control-plaintext');
                    inpqty.removeAttr("readonly");
                    inpqty.addClass('form-control');

                    saveButton.removeClass('d-none');
                    cancelButton.removeClass('d-none');
                    editButton.addClass('d-none');
                    deleteButton.addClass('d-none');
                }
            });

            $('#assetTable').on('click', '.button-save2', function(e){
                e.preventDefault();

                var saveButton = $(this);
                var inpName = saveButton.closest('tr').find('input.nameAsset');
                var inpPrice = saveButton.closest('tr').find('input.priceAsset');
                var inpyear = saveButton.closest('tr').find('input.yearAsset');
                var inpmonth = saveButton.closest('tr').find('select.monthAsset');
                var value_name = inpName.val();
                var value_month = inpmonth.val();
                var value_year = parseInt(inpyear.val());
                var value_price = parseInt(inpPrice.val());
                var id = saveButton.parents("tr").attr("data-id");
                var report_id = saveButton.parents("tr").attr("data-report-id");
                
                $.ajax({
                    url: '{{ route('update.details-report') }}',
                    type: "post",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "report_id": report_id,
                        "name" : value_name,
                        "month_asset" : value_month,
                        "year_asset" : value_year,
                        "price" : value_price,
                        "type" : 'Asset'
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(response) {
                        let keyname;
                        let keymessage;
                        // console.log('Sekarang error')
                        $.each(response.responseJSON.errors, function(key, value){
                            keyname = key;
                            keymessage = value;
                        });
                        // console.log(response.responseJSON);
                        inpName.closest('td').find('.invalid-feedback').empty();
                        inpName.removeClass('is-invalid');
                        inpyear.closest('td').find('.invalid-feedback').empty();
                        inpyear.removeClass('is-invalid');
                        inpmonth.closest('td').find('.invalid-feedback').empty();
                        inpmonth.removeClass('is-invalid');
                        inpPrice.closest('td').find('.invalid-feedback').empty();
                        inpPrice.removeClass('is-invalid');
                        if (keyname == inpName.attr('name')){
                            inpName.addClass('is-invalid');
                            inpName.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == inpyear.attr('name')){
                            inpyear.addClass('is-invalid');
                            inpyear.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == inpmonth.attr('name')){
                            inpmonth.addClass('is-invalid');
                            inpmonth.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == inpPrice.attr('name')){
                            inpPrice.addClass('is-invalid');
                            inpPrice.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        
                    }
                });

            });

            $('#assetTable').on('click', '.button-cancel2', function(e){
                e.preventDefault();
                window.location.reload();
            });

            $('#assetTable').on('click', '.single-stuff2', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var url = `{{ url('/detail-report/${id}') }}`;

                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": id,
                        },
                        success: function (data) {
                             window.location.reload();
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
@endpush
