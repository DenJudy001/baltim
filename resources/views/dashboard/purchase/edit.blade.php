@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/transactions">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Data Pemesanan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $purchase->purchase_number }}</h4></div>
            @if ($purchase->state == 'Proses')
                <div class="col text-right">
                    <div class="d-flex justify-content-end" id="changeStatus" data-purchase-id="{{ $purchase->id }}">
                        <a class="btn btn-success shadow-sm button-finished mr-1"><i class="fas fa-check mr-2"></i>{{ __('Selesai') }}</a>
                        <a class="btn btn-danger shadow-sm button-cancelled"><i class="fas fa-times mr-2"></i>{{ __('Batal') }}</a>
                    </div>
                </div>
            @endif
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%" >Jenis Transaksi</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$purchase->purchase_name}}</td>
                    </tr>
                    <tr>
                        <td width="38%" >Pemasok</td>
                        <td width="2%" >:</td>
                        <td width="60%" >{{$purchase->supplier_name}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Alamat</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$purchase->address}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Pemilik</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$purchase->supplier_responsible}}</td>
                    </tr>
                    <tr>
                        <td width="38%">No. Telp</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$purchase->telp}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Status</td>
                        <td width="2%">:</td>
                        <td width="60%"><span class="badge {{ $purchase->state == 'Proses' ? 'text-bg-warning' : ($purchase->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$purchase->state}}</span></td>
                    </tr>
                    <tr>
                        <td width="38%">Tanggal pemesanan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{date('d-m-Y H:i', strtotime($purchase->created_at))}} (oleh @can('admin') <a href="/employee/{{ $purchase->responsible }}">{{ $purchase->responsible }}</a>@else {{ $purchase->responsible }} @endcan)</td>
                    </tr>
                    @if ($purchase->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{date('d-m-Y H:i', strtotime($purchase->end_date))}} (oleh @can('admin') <a href="/employee/{{ $purchase->end_by }}">{{ $purchase->end_by }}</a>@else {{ $purchase->end_by }} @endcan)</td>
                        </tr>
                    @endif
                    <tr>
                        <td width="38%" class="font-weight-bold">Total</td>
                        <td width="2%" class="font-weight-bold">:</td>
                        <td width="60%" class="font-weight-bold">Rp. {{number_format($purchase->total, 0, ',', '.')}}</td>
                    </tr>          
                </table>
            </div>
        </div>              
    </div>
</div>
@if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">Rincian Pemesanan</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table" width="100%" id="PurchaseTable">
                    <thead>
                        <tr data-supp-id="{{ $purchase->supplier_id }}">
                            <th scope="col" width="20%">Produk</th>
                            <th scope="col" width="30%">Keterangan</th>
                            <th scope="col" width="5%">Jumlah</th>
                            <th scope="col" width="5%">Unit</th>
                            <th scope="col" width="30%">Total Harga</th>
                            <th scope="col" width="10%">
                                <div  class="d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="btn btn-success addRowPurchase"><i class="fas fa-plus"></i></a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="detail-trx">
                        @foreach ($purchase->dtl_purchase as $details)
                            <tr data-id="{{ $details->id }}" data-purchase-id="{{ $purchase->id }}">
                                <td><select class="form-select single-select-stuff stuff-name" data-placeholder="Pilih Produk"
                                    name="name" aria-describedby="inputGroupPrepend3 validationServerStuffNameFeedback" required disabled>
                                    <option></option>
                                        @foreach ($stuffs as $stuff)
                                            <option value="{{ $stuff->stuff_name }}" @if(old('name', $details->name) == $stuff->stuff_name) selected @endif>{{ $stuff->stuff_name }}</option>
                                        @endforeach
                                </select>
                                <div id="validationServerStuffNameFeedback" class="invalid-feedback d-none">Silahkan simpan data terlebih dahulu</div></td>
                                <td><textarea class="form-control-plaintext stuff-desc" name="description" readonly>{{ old('description',$details->description) }}</textarea></td>
                                <td><input type="number" class="form-control-plaintext stuff-qty" name="qty" value="{{ old('qty',$details->qty) }}" data-price-per-qty="{{ $details->price/$details->qty }}" required readonly></td>
                                <td><select class="form-select single-select-unit stuff-unit" data-placeholder="Pilih Satuan" name="unit" required disabled>
                                    <option></option>
                                    <option @if(old('unit', $details->unit) == 'kg (kilogram)') selected @endif>kg (kilogram)</option>
                                    <option @if(old('unit', $details->unit) == 'gr (gram)') selected @endif>gr (gram)</option>
                                    <option @if(old('unit', $details->unit) == 'ltr (liter)') selected @endif>ltr (liter)</option>
                                    <option @if(old('unit', $details->unit) == 'ekor') selected @endif>ekor</option>
                                    <option @if(old('unit', $details->unit) == 'lembar') selected @endif>lembar</option>
                                </select></td>
                                <td><input type="text" class="form-control-plaintext priceFormat" value="Rp. {{ number_format($details->price, 0, ',', '.') }}" readonly><input type="hidden" class="form-control-plaintext stuff-price" name="price" value="{{ old('price',$details->price) }}" required readonly></td>
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
</div>
@endsection

@push('script')
    <script>
        function selectRefresh($sel, $sel2) {
        $sel.select2({
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            tags : true
        });
        $sel2.select2({
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
            $('thead').on('click', '.addRowPurchase', function(){
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('select.stuff-name');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerStuffNameFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerStuffName');
                    errorMSG.removeClass('d-none');
                }
                else{
                    var id = $(this).parents("tr").attr("data-supp-id");
                    var url = "{{ URL::to('purchsupp-dropdown') }}";
                    var name = "single-select-stuff";
                    if(id){
                        if(window.data && window.data.stuffFiltered){

                        } else{
                            $.ajax({
                                url : url,
                                type: 'GET',
                                data: {
                                    "id" : id,
                                    "_token": $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(data){
                                    let select = $('.' + name).last();
                                    select.empty();
                                    select.attr('placeholder', select.data('placeholder'));
                                    select.append(`<option></option>`);
                                    $.each(data, function(key, value){
                                        select.append(`<option>${value}</option>`);
                                    });

                                    if (typeof window.data === 'undefined') {
                                        window.data = {};
                                    }
                                    window.data.stuffFiltered = data;
                                }
                            });
                        }
                    }

                    var tr = "<tr data-purchase-id='{{ $purchase->id }}''>"+
                                "<td>"+
                                "<select class='form-select single-select-stuff stuff-name' data-placeholder='Pilih Produk' name='name' aria-describedby='inputGroupPrepend3 validationServerStuffNameFeedback' required>"+
                                    "<option></option>"+
                                "</select>"+
                                "<div id='validationServerStuffNameFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>"+
                                "</td>"+
                                "<td><textarea class='form-control stuff-desc' name='description[]' ></textarea></td>"+
                                "<td><input type='number' class='form-control stuff-qty' name='qty' value=1 data-price-per-qty='0' min='1' required></td>"+
                                "<td>"+
                                    "<select class='form-select single-select-unit stuff-unit' data-placeholder='Pilih Satuan' name='unit' required>"+
                                        "<option></option>"+
                                        "<option>kg (kilogram)</option>"+
                                        "<option>gr (gram)</option>"+
                                        "<option>ltr (liter)</option>"+
                                        "<option>ekor</option>"+
                                        "<option>lembar</option>"+
                                    "</select>"+
                                "</td>"+
                                "<td><input type='number' class='form-control stuff-price' name='price' value=0 required></td>"+
                                "<td>"+
                                    "<div class='d-flex justify-content-between'>"+
                                    "<a class='btn btn-success button-save col-sm-6 mr-1'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit d-none col-sm-6'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel d-none col-sm-6'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger col-sm-6 deleteRowPurchase'><i class='fas fa-trash-alt'></i></a>"+
                                    "</div>"+
                                "</td>"+
                            "</tr>"
                    $('tbody.detail-trx').append(tr);
                    var $select_stuff = $('.single-select-stuff').last();
                    var $select_unit = $('.single-select-unit').last();
                    selectRefresh($select_stuff, $select_unit);
                    
                    if(window.data && window.data.stuffFiltered){
                        $select_stuff.attr('placeholder', $select_stuff.data('placeholder'));
                        $select_stuff.append(`<option></option>`);
                        $.each(window.data.stuffFiltered, function(key, value){
                            $select_stuff.append(`<option>${value}</option>`);
                        });
                    }
                }

            });

            $('tbody').on('click', '.deleteRowPurchase', function(){
                $(this).parent().parent().parent().remove();
            });

            $( '.single-select-stuff' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                tags : true
            } );
            $( '.single-select-unit' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                language: {
                    "noResults": function(){
                        return "Data Tidak ditemukan";
                    }
                }
            } );

            $('#PurchaseTable').on('change', '.single-select-stuff', function(){
                var name = $(this).val();
                var url = "{{ URL::to('purchstuff-dropdown') }}";
                var desc = $(this).closest('tr').find('textarea.stuff-desc');
                var qty = $(this).closest('tr').find('input.stuff-qty');
                var price = $(this).closest('tr').find('input.stuff-price');
                
                $.ajax({
                    url : url,
                    type: 'GET',
                    data: {
                        "stuff_name" : name,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        desc.val(data.description);
                        price.val(data.price);
                        qty.val(1);
                        qty.data('price-per-qty', data.price);
                    },
                    error: function(data){
                        // console.log('Error:', data);
                    }
                }) 
            });

            $('#PurchaseTable').on('click', '.button-edit', function(){
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('select.stuff-name');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerStuffNameFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerStuffName');
                    errorMSG.removeClass('d-none');
                } else{
                    var saveButton = $(this).closest('td').find('a.button-save');
                    var editButton = $(this);
                    var cancelButton = $(this).closest('td').find('a.button-cancel');
                    var deleteButton = $(this).closest('td').find('a.single-stuff');
                    var inpName = editButton.closest('tr').find('select.stuff-name');
                    var inpDesc = editButton.closest('tr').find('textarea.stuff-desc');
                    var inpqty = editButton.closest('tr').find('input.stuff-qty');
                    var inpunit = editButton.closest('tr').find('select.stuff-unit');
                    var inpPrice = editButton.closest('tr').find('input.stuff-price');
                    var inpPriceFormat = editButton.closest('tr').find('input.priceFormat');

                    inpName.removeAttr("disabled");
                    inpunit.removeAttr("disabled");

                    inpDesc.removeClass('form-control-plaintext');
                    inpDesc.removeAttr("readonly");
                    inpDesc.addClass('form-control');

                    inpqty.removeClass('form-control-plaintext');
                    inpqty.removeAttr("readonly");
                    inpqty.addClass('form-control');


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

            $('#PurchaseTable').on('click', '.button-save', function(e){
                e.preventDefault();

                var saveButton = $(this);
                var stuff_name = saveButton.closest('tr').find('select.stuff-name');
                var description = saveButton.closest('tr').find('textarea.stuff-desc');
                var qty = saveButton.closest('tr').find('input.stuff-qty');
                var unit = saveButton.closest('tr').find('select.stuff-unit');
                var price = saveButton.closest('tr').find('input.stuff-price');
                var value_stuff_name = stuff_name.val();
                var value_description = description.val();
                var value_unit = unit.val();
                var value_qty = parseInt(qty.val());
                var value_price = parseInt(price.val());
                var id = saveButton.parents("tr").attr("data-id");
                var purchase_id = saveButton.parents("tr").attr("data-purchase-id");
                
                $.ajax({
                    url: '{{ route('update.details-purchase') }}',
                    type: "post",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "purchase_id": purchase_id,
                        "name" : value_stuff_name,
                        "description" : value_description,
                        "unit" : value_unit,
                        "qty" : value_qty,
                        "price" : value_price
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
                        stuff_name.closest('td').find('.invalid-feedback').empty();
                        stuff_name.removeClass('is-invalid');
                        qty.closest('td').find('.invalid-feedback').empty();
                        qty.removeClass('is-invalid');
                        unit.closest('td').find('.invalid-feedback').empty();
                        unit.removeClass('is-invalid');
                        price.closest('td').find('.invalid-feedback').empty();
                        price.removeClass('is-invalid');
                        if (keyname == stuff_name.attr('name')){
                            stuff_name.addClass('is-invalid');
                            stuff_name.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == qty.attr('name')){
                            qty.addClass('is-invalid');
                            qty.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == unit.attr('name')){
                            unit.addClass('is-invalid');
                            unit.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == price.attr('name')){
                            price.addClass('is-invalid');
                            price.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        
                    }
                });

            });

            $('#PurchaseTable').on('click', '.button-cancel', function(e){
                e.preventDefault();
                window.location.reload();
            });

            $('#PurchaseTable').on('click', '.single-stuff', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var purchase_id = $(this).parents("tr").attr("data-purchase-id");
                var url = `{{ url('/detail-purchase/${id}') }}`;

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
                            url: url,
                            type: 'DELETE',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": id,
                                "purchase_id": purchase_id,
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
            });

            $('#changeStatus').on('click', '.button-finished', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Selesai";

                Swal.fire({
                    title: 'Apakah Anda yakin ingin menyelesaikan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1cc88a',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "purchase_id": purchase_id,
                                "state": newStatus
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Berhasil!',
                                    text:'Transaksi telah diselesaikan.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.replace('/transactions');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat merubah status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            $('#changeStatus').on('click', '.button-cancelled', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Dibatalkan";

                Swal.fire({
                    title: 'Apakah Anda yakin ingin membatalkan pemesanan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#858796',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "purchase_id": purchase_id,
                                "state": newStatus
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Berhasil!',
                                    text:'Transaksi telah dibatalkan.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.replace('/transactions');
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat merubah status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            $('#PurchaseTable').on('keyup', 'input.stuff-qty', function(e){
                e.preventDefault();
                let qty = $(this);
                let value_qty = parseInt(qty.val());
                let price = $(this).closest('tr').find('input.stuff-price');
                let value_price = parseInt(price.val());
                let single_price = parseFloat(qty.data('price-per-qty'));

                if (!isNaN(single_price) && single_price!=0) {
                    let new_price = single_price * value_qty;
                    price.val(new_price);
                }
            });
        });
    </script>
@endpush