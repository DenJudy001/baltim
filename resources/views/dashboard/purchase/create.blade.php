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
                        <label for="supplier_id" class="form-label @error('supplier_id') is-invalid @enderror">Pemasok</label>
                        <select class="form-select single-select-supplier" name="supplier_id" id="sel_supplier_id" data-placeholder="Pilih Pemasok" required>
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
                <div class="row">
                    <div class="table-responsive">
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
                        <table class="table table-light" id="PurchaseTable">
                            <thead>
                                <tr>
                                    <th scope="col" nowrap>Nama Bahan</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col" nowrap>Sub Total</th>
                                    <th scope="col"><a href="javascript:void(0)" class="btn btn-success addRowPurchase">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select single-select-stuff" data-placeholder="Pilih Barang" name="stuff_name[]" required>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td><textarea  class="form-control descID" name="description[]"></textarea></td>
                                    <td><input type="number" class="form-control qtyID" name="qty[]" value=1 required></td>
                                    <td>
                                        <select class="form-select single-select-unit" data-placeholder="Pilih Satuan" name="unit[]" required>
                                            <option></option>
                                            <option>kg (kilogram)</option>
                                            <option>gr (gram)</option>
                                            <option>ltr (liter)</option>
                                            <option>ekor</option>
                                            <option>lembar</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control priceID" name="price[]" value=0 required></td>
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
                                    <td ><div class="d-flex justify-content-end">Total Harga :</div></td>
                                    <td colspan="2"><input type="number" class="form-control-plaintext text-left" name="total" id="totalPurchase" value="0" readonly></td>
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
                            "<select class='form-select single-select-stuff' data-placeholder='Pilih Barang' name='stuff_name[]' required>"+
                                "<option></option>"+
                            "</select>"+
                            "</td>"+
                            "<td><textarea class='form-control descID' name='description[]' ></textarea></td>"+
                            "<td><input type='number' class='form-control qtyID' name='qty[]' value=1 required></td>"+
                            "<td>"+
                                "<select class='form-select single-select-unit' data-placeholder='Pilih Satuan' name='unit[]' required>"+
                                    "<option></option>"+
                                    "<option>kg (kilogram)</option>"+
                                    "<option>gr (gram)</option>"+
                                    "<option>ltr (liter)</option>"+
                                    "<option>ekor</option>"+
                                    "<option>lembar</option>"+
                                "</select>"+
                            "</td>"+
                            "<td><input type='number' class='form-control priceID' name='price[]' value=0 required></td>"+
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
                allowClear: true
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

