@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Buat Pemesanan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/purchase" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label @error('supplier_id') is-invalid @enderror">Pemasok<span class="text-danger">*</span></label>
                        <select class="form-select single-select-supplier" name="supplier_id" id="sel_supplier_id" data-placeholder="Pilih Pemasok" required oninvalid="this.setCustomValidity('Pemasok tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            <option></option>
                            @foreach ($suppliers as $supp)
                                <option value="{{ $supp->id }}">{{ $supp->supplier_name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row mt-2">
                    <h4 class="fw-bold">Rincian Pemesanan</h4>
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error_validate ) 
                                    <li>
                                        {{ $error_validate }}
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive mt-2">
                        <table class="table" id="PurchaseTable">
                            <thead>
                                <tr>
                                    <th scope="col" width="20%" nowrap>Nama Bahan<span class="text-danger">*</span></th>
                                    <th scope="col" width="25%">Deskripsi</th>
                                    <th scope="col" width="10%">Jumlah<span class="text-danger">*</span></th>
                                    <th scope="col" width="10%">Satuan<span class="text-danger">*</span></th>
                                    <th scope="col" width="15%">Harga<span class="text-danger">*</span></th>
                                    <th scope="col" width="15%" nowrap>Sub Total</th>
                                    <th scope="col" width="5%"><a href="javascript:void(0)" class="btn btn-success addRowPurchase">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select single-select-stuff" data-placeholder="Pilih Barang" name="stuff_name[]" required oninvalid="this.setCustomValidity('Nama tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                                            <option></option>
                                        </select>
                                    </td>
                                    <td><textarea  class="form-control descID" name="description[]"></textarea></td>
                                    <td><input type="number" class="form-control qtyID" name="qty[]" value=1 required min='1' onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Kuantitas tidak boleh kosong !')" oninput="this.setCustomValidity('')"></td>
                                    <td>
                                        <select class="form-select single-select-unit" data-placeholder="Pilih Satuan" name="unit[]" required oninvalid="this.setCustomValidity('Satuan tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                                            <option></option>
                                            <option>kg (kilogram)</option>
                                            <option>gr (gram)</option>
                                            <option>ltr (liter)</option>
                                            <option>ekor</option>
                                            <option>lembar</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control priceID" name="price[]" value=0 required min='1' onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Harga tidak boleh kosong !')" oninput="this.setCustomValidity('')"></td>
                                    <td><input type="number" class="form-control subtotalID" value=0 disabled></td>
                                    <td>
                                        {{-- <a href="javascript:void(0)" class="btn btn-danger deleteRowPurchase"><span data-feather='trash'></span></a> --}}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr >
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align-middle"><div class="d-flex justify-content-end"><span nowrap>Total Harga :</span></div></td>
                                    <td colspan="2" nowrap><div class="d-flex align-items-top"><input type="number" class="form-control-plaintext text-left" name="total" id="totalPurchase" value="0" readonly></div></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Buat Pemesanan</button>
            </form>
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
            function onChangeSelect(url, id, name){
                $.ajax({
                    url : url,
                    type: 'GET',
                    data: {
                        "id" : id,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        let select = $('.' + name);
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
                })
            }

            $('thead').on('click', '.addRowPurchase', function(){
                var tr = "<tr>"+
                            "<td>"+
                            "<select class='form-select single-select-stuff' data-placeholder='Pilih Barang' name='stuff_name[]' required oninvalid=\"this.setCustomValidity('Nama tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                                "<option></option>"+
                            "</select>"+
                            "</td>"+
                            "<td><textarea class='form-control descID' name='description[]' ></textarea></td>"+
                            "<td><input type='number' class='form-control qtyID' name='qty[]' value=1 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Kuantitas tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td>"+
                                "<select class='form-select single-select-unit' data-placeholder='Pilih Satuan' name='unit[]' required oninvalid=\"this.setCustomValidity('Satuan tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\">"+
                                    "<option></option>"+
                                    "<option>kg (kilogram)</option>"+
                                    "<option>gr (gram)</option>"+
                                    "<option>ltr (liter)</option>"+
                                    "<option>ekor</option>"+
                                    "<option>lembar</option>"+
                                "</select>"+
                            "</td>"+
                            "<td><input type='number' class='form-control priceID' name='price[]' value=0 required min='1' onkeypress=\"return event.charCode >= 48 && event.charCode <= 57\" oninvalid=\"this.setCustomValidity('Harga tidak boleh kosong !')\" oninput=\"this.setCustomValidity('')\"></td>"+
                            "<td><input type='number' class='form-control subtotalID' value=0 disabled></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRowPurchase'><i class='fas fa-trash-alt'></i></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody').append(tr);
                // feather.replace();
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

            });

            function countTotalHarga(){
                var totalHarga = $('#totalPurchase');
                var subtotal = $('.subtotalID');
                var result = 0;
                subtotal.each(function(){
                    result = result + parseInt($(this).val());
                });
                totalHarga.val(result);
            }

            $('tbody').on('click', '.deleteRowPurchase', function(){
                $(this).parent().parent().remove();
                countTotalHarga();
            });

            $( '.single-select-supplier' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: true,
                language: {
                    "noResults": function(){
                        return "Data Tidak ditemukan";
                    }
                }
            } );
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

            $("#sel_supplier_id").change(function(){
                var id = $(this).val();
                var url = "{{ URL::to('purchsupp-dropdown') }}";
                var name = "single-select-stuff";
                var desc = "textarea.descID";
                var price = "input.priceID";
                var qty = "input.qtyID";
                var subtotal = "input.subtotalID";
                if (id){
                    onChangeSelect(url, id, name);
                    $(desc).val('');
                    $(price).val(0);
                    $(qty).val(1);
                    $(subtotal).val(0);
                }else{
                    $('.' + name).empty();
                    $(desc).val('');
                    $(price).val(0);
                    $(qty).val(1);
                    $(subtotal).val(0);
                }
            });

            $('#PurchaseTable').on('change', '.single-select-stuff', function(){
                var name = $(this).val();
                var url = "{{ URL::to('purchstuff-dropdown') }}";
                var desc = $(this).closest('tr').find('textarea.descID');
                var price = $(this).closest('tr').find('input.priceID');
                var qty = $(this).closest('tr').find('input.qtyID').val();
                var subtotal = $(this).closest('tr').find('input.subtotalID');
                
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
                        var result = parseInt(price.val()) * parseInt(qty);
                        if (!isNaN(result)) {
                                subtotal.val(result);
                            }
                            if (result < 0) {
                                subtotal.val(0);
                        }
                        countTotalHarga();
                    },
                    error: function(data){
                        console.log('Error:', data);
                    }
                })
                
            });

            $('#PurchaseTable').on('keyup', '.qtyID', function(){
                var qty = $(this).val();
                var price = $(this).closest('tr').find('input.priceID').val();
                var subtotal = $(this).closest('tr').find('input.subtotalID');
                var result = parseInt(price) * parseInt(qty);
                if (!isNaN(result)) {
                    subtotal.val(result);
                }
                if (result < 0) {
                    subtotal.val(0);
               }
               countTotalHarga();
            });

            $('#PurchaseTable').on('keyup', '.priceID', function(){
                var price = $(this).val();
                var qty = $(this).closest('tr').find('input.qtyID').val();
                var subtotal = $(this).closest('tr').find('input.subtotalID');
                var result = parseInt(price) * parseInt(qty);

                if (!isNaN(result)) {
                    subtotal.val(result);
                }
                if (result < 0) {
                    subtotal.val(0);
               }
               countTotalHarga();
            });
        });

    </script>
@endpush

