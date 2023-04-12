@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="/account">Daftar Transaksi</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ubah Data Penjualan</li>
        </ol>
    </nav>
</div>
<div class="card mb-3">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $pos->pos_number }}</h4></div>
            @if ($pos->state == 'Proses')
                <div class="col text-right" id="changeStatus" data-pos-id="{{ $pos->id }}">
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
                        <td width="38%">Tanggal pemesanan</td>
                        <td width="2%">:</td>
                        <td width="60%">{{$pos->created_at}} (oleh @can('admin') <a href="/employee/{{ $pos->responsible }}">{{ $pos->responsible }}</a>@else {{ $pos->responsible }} @endcan)</td>
                    </tr>
                    @if ($pos->end_date)
                        <tr>
                            <td width="38%">Tanggal Selesai</td>
                            <td width="2%">:</td>
                            <td width="60%">{{$pos->end_date}} (oleh @can('admin') <a href="/employee/{{ $pos->end_by }}">{{ $pos->end_by }}</a>@else {{ $pos->end_by }} @endcan)</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="col-sm-6">
                <table width="100%" class="table table-borderless">
                    <tr>
                        <td width="38%">Status</td>
                        <td width="2%">:</td>
                        <td width="60%" ><span class="badge {{ $pos->state == 'Proses' ? 'text-bg-warning' : ($pos->state == 'Selesai' ? 'text-bg-success' : 'text-bg-danger') }}">{{$pos->state}}</span></td>
                    </tr>
                    <tr>
                        <td width="38%" class="font-weight-bold">Total</td>
                        <td width="2%" class="font-weight-bold">:</td>
                        <td width="60%" class="font-weight-bold">Rp. {{number_format($pos->total, 0, ',', '.')}}</td>
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
            <div class="col"><h4 class="font-weight-bold">Rincian Penjualan</h4></div>
        </div>                 
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table" width="100%" id="PosTable">
                    <thead>
                        <tr>
                            <th width="25%">Menu</th>
                            <th width="40%">Keterangan</th>
                            <th width="10%">Jumlah</th>
                            <th width="15%">Harga</th>
                            <th scope="col" width="10%">
                                <div  class="d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="btn btn-success addRowPos">+</a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="detail-pos">
                        @foreach ($pos->dtl_pos as $details)
                            <tr data-id="{{ $details->id }}" data-pos-id="{{ $pos->id }}">
                                <td><select class="form-select single-select-menu menu-name" data-placeholder="Pilih Menu"
                                    name="name" aria-describedby="inputGroupPrepend3 validationServerMenuNameFeedback" required disabled>
                                    <option></option>
                                        @foreach ($menus as $menu)
                                            <option value="{{ $menu->name }}" @if(old('name', $details->name) == $menu->name) selected @endif>{{ $menu->name }}</option>
                                        @endforeach
                                </select>
                                <div id="validationServerMenuNameFeedback" class="invalid-feedback d-none">Silahkan simpan data terlebih dahulu</div></td>
                                <td><textarea class="form-control-plaintext menu-desc" name="description" readonly>{{ old('description',$details->description) }}</textarea></td>
                                <td><input type="number" class="form-control-plaintext menu-qty" name="qty" value="{{ old('qty',$details->qty) }}" required readonly></td>
                                <td><input type="number" class="form-control-plaintext menu-price" name="price" value="{{ old('price',$details->price) }}" required readonly></td>
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
            $('thead').on('click', '.addRowPos', function(){
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('select.menu-name');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerMenuNameFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerMenuName');
                    errorMSG.removeClass('d-none');
                }
                else{
                    var url = "{{ URL::to('posmenu-dropdown') }}";
                    var name = "single-select-menu";
                    if(window.data && window.data.MenuFiltered){

                    } else{
                        $.ajax({
                            url : url,
                            type: 'GET',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data){
                                let select = $('.' + name).last();
                                select.empty();
                                select.attr('placeholder', select.data('placeholder'));
                                select.append(`<option></option>`);
                                $.each(data.menu, function(key, value){
                                    select.append(`<option>${value}</option>`);
                                });

                                if (typeof window.data === 'undefined') {
                                    window.data = {};
                                }
                                window.data.MenuFiltered = data.menu;
                            }
                        });
                    }

                    var tr = "<tr data-pos-id='{{ $pos->id }}'>"+
                                "<td>"+
                                "<select class='form-select single-select-menu menu-name' data-placeholder='Pilih Menu' name='name' aria-describedby='inputGroupPrepend3 validationServerMenuNameFeedback' required>"+
                                    "<option></option>"+
                                "</select>"+
                                "<div id='validationServerMenuNameFeedback' class='invalid-feedback d-none'>Silahkan simpan data terlebih dahulu</div>"+
                                "</td>"+
                                "<td><textarea class='form-control menu-desc' name='description[]' ></textarea></td>"+
                                "<td><input type='number' class='form-control menu-qty' name='qty' value=1 required></td>"+
                                "<td><input type='number' class='form-control menu-price' name='price' value=0 required></td>"+
                                "<td>"+
                                    "<div class='d-flex justify-content-between'>"+
                                    "<a class='btn btn-success button-save col-sm-6 mr-1'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit d-none col-sm-6'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel d-none col-sm-6'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger col-sm-6 deleteRowPos'><i class='fas fa-trash-alt'></i></a>"+
                                    "</div>"+
                                "</td>"+
                            "</tr>"
                    $('tbody.detail-pos').append(tr);
                    var $select_menu = $('.single-select-menu').last();
                    selectRefresh($select_menu);
                    
                    if(window.data && window.data.MenuFiltered && window.data.CategFiltered){
                        $select_menu.attr('placeholder', $select_menu.data('placeholder'));
                        $select_menu.append(`<option></option>`);
                        $.each(window.data.MenuFiltered, function(key, value){
                            $select_menu.append(`<option>${value}</option>`);
                        });
                    }
                }

            });

            $('tbody').on('click', '.deleteRowPos', function(){
                $(this).parent().parent().parent().remove();
            });


            $( '.single-select-menu' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                language: {
                    "noResults": function(){
                        return "Data Tidak ditemukan";
                    }
                }
            } );

            $('#PosTable').on('change', '.single-select-menu', function(){
                var name = $(this).val();
                var url = "{{ URL::to('posmenudetails-dropdown') }}";
                var desc = $(this).closest('tr').find('textarea.menu-desc');
                var price = $(this).closest('tr').find('input.menu-price');
                
                $.ajax({
                    url : url,
                    type: 'GET',
                    data: {
                        "name" : name,
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

            $('#PosTable').on('click', '.button-edit', function(){
                var editButtonLoc = $('.button-edit');

                if (editButtonLoc.hasClass('d-none')) {
                    var hiddenLoc = $('a.button-edit.d-none');
                    var stuffLoc = hiddenLoc.closest('tr').find('select.menu-name');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerMenuNameFeedback');

                    stuffLoc.addClass('is-invalid');
                    stuffLoc.attr('id','validationServerMenuName');
                    errorMSG.removeClass('d-none');
                } else{
                    var saveButton = $(this).closest('td').find('a.button-save');
                    var editButton = $(this);
                    var cancelButton = $(this).closest('td').find('a.button-cancel');
                    var deleteButton = $(this).closest('td').find('a.single-stuff');
                    var inpName = editButton.closest('tr').find('select.menu-name');
                    var inpDesc = editButton.closest('tr').find('textarea.menu-desc');
                    var inpqty = editButton.closest('tr').find('input.menu-qty');
                    var inpPrice = editButton.closest('tr').find('input.menu-price');

                    inpName.removeAttr("disabled");

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

            $('#PosTable').on('click', '.button-save', function(e){
                e.preventDefault();

                var saveButton = $(this);
                var stuff_name = saveButton.closest('tr').find('select.menu-name');
                var description = saveButton.closest('tr').find('textarea.menu-desc');
                var qty = saveButton.closest('tr').find('input.menu-qty');
                var price = saveButton.closest('tr').find('input.menu-price');
                var value_stuff_name = stuff_name.val();
                var value_description = description.val();
                var value_qty = parseInt(qty.val());
                var value_price = parseInt(price.val());
                var id = saveButton.parents("tr").attr("data-id");
                var pos_id = saveButton.parents("tr").attr("data-pos-id");
                
                $.ajax({
                    url: '{{ route('update.details-pos') }}',
                    type: "post",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "pos_id": pos_id,
                        "name" : value_stuff_name,
                        "description" : value_description,
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
                        if (keyname == price.attr('name')){
                            price.addClass('is-invalid');
                            price.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        
                    }
                });

            });

            $('#PosTable').on('click', '.button-cancel', function(e){
                e.preventDefault();
                window.location.reload();
            });

            $('#changeStatus').on('click', '.button-finished', function(e){
                e.preventDefault();
                var url = '{{ route('update.status-pos') }}';
                var pos_id = $(this).parents("div").attr("data-pos-id");
                var newStatus = "Selesai";
                if (confirm('Apakah Anda yakin ingin menyelesaikan transaksi?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "pos_id": pos_id,
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
                var url = '{{ route('update.status-pos') }}';
                var pos_id = $(this).parents("div").attr("data-pos-id");
                var newStatus = "Dibatalkan";
                if (confirm('Apakah Anda yakin ingin membatalkan transaksi?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "pos_id": pos_id,
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

            $('#PosTable').on('click', '.single-stuff', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var pos_id = $(this).parents("tr").attr("data-pos-id");
                var url = `{{ url('/detail-pos/${id}') }}`;

                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": id,
                            "pos_id": pos_id,
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