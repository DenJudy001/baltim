@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/account">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Data Pemesanan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $purchase->purchase_number }}</h4></div>
            @if ($purchase->state == 'Proses')
                <div class="col text-right" id="changeStatus" data-purchase-id="{{ $purchase->id }}">
                    <a class="btn btn-success shadow-sm button-finished">{{ __('Selesaikan') }}</a>
                    <a class="btn btn-danger shadow-sm button-cancelled">{{ __('Batalkan') }}</a>
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
                        <td width="60%">{{$purchase->state}}</td>
                    </tr>
                    <tr>
                        <td width="38%">Tanggal pemesanan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$purchase->created_at}} (oleh {{ $purchase->responsible }})</td>
                    </tr>
                    @if ($purchase->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$purchase->end_date}} (oleh {{ $purchase->end_by }})</td>
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
            <div class="col-sm-12">
                <table class="table table-sm" width="100%" id="PurchaseTable">
                    <thead>
                        <tr data-supp-id="{{ $purchase->supplier_id }}">
                            <th>Produk</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Unit</th>
                            <th>Harga</th>
                            <th scope="col">
                                <div  class="d-flex justify-content-center">
                                    <a href="javascript:void(0)" class="btn btn-success addRowPurchase">+</a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="detail-trx">
                        @foreach ($purchase->dtl_purchase as $details)
                            <tr data-id="{{ $details->id }}" data-purchase-id="{{ $purchase->id }}">
                                <td><select class="form-select single-select-stuff stuff-name" data-placeholder="Pilih Bahan/Barang"
                                    name="name" aria-describedby="inputGroupPrepend3 validationServerStuffNameFeedback" required disabled>
                                    <option></option>
                                        @foreach ($stuffs as $stuff)
                                            <option value="{{ $stuff->stuff_name }}" @if(old('name', $details->name) == $stuff->stuff_name) selected @endif>{{ $stuff->stuff_name }}</option>
                                        @endforeach
                                </select>
                                <div id="validationServerStuffNameFeedback" class="invalid-feedback d-none">Silahkan simpan data terlebih dahulu</div></td>
                                <td><textarea class="form-control-plaintext stuff-desc" name="description" readonly>{{ old('description',$details->description) }}</textarea></td>
                                <td><input type="number" class="form-control-plaintext stuff-qty" name="qty" value="{{ old('qty',$details->qty) }}" required readonly></td>
                                <td><select class="form-select single-select-unit stuff-unit" data-placeholder="Pilih Satuan" name="unit" required disabled>
                                    <option></option>
                                    <option @if(old('unit', $details->unit) == 'kg (kilogram)') selected @endif>kg (kilogram)</option>
                                    <option @if(old('unit', $details->unit) == 'gr (gram)') selected @endif>gr (gram)</option>
                                    <option @if(old('unit', $details->unit) == 'ltr (liter)') selected @endif>ltr (liter)</option>
                                    <option @if(old('unit', $details->unit) == 'ekor') selected @endif>ekor</option>
                                    <option @if(old('unit', $details->unit) == 'lembar') selected @endif>lembar</option>
                                </select></td>
                                <td><input type="number" class="form-control-plaintext stuff-price" name="price" value="{{ old('price',$details->price) }}" required readonly></td>
                                <td>
                                    <a class="btn btn-success button-save d-none" ><i class="fas fa-check"></i></a>
                                    <a class="btn btn-warning button-edit"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-danger button-cancel d-none"><i class="fas fa-times"></i></a>
                                    <a class="btn btn-danger single-stuff"><i class="fas fa-trash-alt"></i></a>
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
                                "<select class='form-select single-select-stuff stuff-name' data-placeholder='Pilih Barang' name='name' aria-describedby='inputGroupPrepend3 validationServerStuffNameFeedback' required>"+
                                    "<option></option>"+
                                "</select>"+
                                "<div id='validationServerStuffNameFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>"+
                                "</td>"+
                                "<td><textarea class='form-control stuff-desc' name='description[]' ></textarea></td>"+
                                "<td><input type='number' class='form-control stuff-qty' name='qty' value=1 required></td>"+
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
                                    "<a class='btn btn-success button-save'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit d-none'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel d-none'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger deleteRowPurchase'><i class='fas fa-trash-alt'></i></a>"+
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
                $(this).parent().parent().remove();
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
                
            } );

            $('#PurchaseTable').on('change', '.single-select-stuff', function(){
                var name = $(this).val();
                var url = "{{ URL::to('purchstuff-dropdown') }}";
                var desc = $(this).closest('tr').find('textarea.stuff-desc');
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

                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": id,
                            "purchase_id": purchase_id,
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

            $('#changeStatus').on('click', '.button-finished', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Selesai";
                if (confirm('Apakah Anda yakin ingin menyelesaikan pemesanan?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "purchase_id": purchase_id,
                            "state": newStatus
                        },
                        success: function (data) {
                            window.location.replace('/account');
                        },
                        error: function (data) {
                            // console.log('Error:', data);
                        }
                    });
                }
            });
            $('#changeStatus').on('click', '.button-cancelled', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-purchase') }}';
                var purchase_id = $(this).parents("div").attr("data-purchase-id");
                var newStatus = "Dibatalkan";
                if (confirm('Apakah Anda yakin ingin membatalkan pemesanan?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "purchase_id": purchase_id,
                            "state": newStatus
                        },
                        success: function (data) {
                            window.location.replace('/account');
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