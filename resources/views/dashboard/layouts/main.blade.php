<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Baltim Resto | Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    {{-- select2 bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Custom styles for this template -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    @include('dashboard.layouts.partials.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.partials.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('container')
            </main>
        </div>
    </div>

    {{-- bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    {{-- feater icons --}}
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    {{-- jquery --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>

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
            
            $('thead').on('click', '.addRow', function(){
                var tr = "<tr>"+
                            "<td><input type='text' class='form-control' name='stuff_name[]' required></td>"+
                            "<td><textarea class='form-control' name='description[]' ></textarea></td>"+
                            "<td><input type='number' class='form-control' name='price[]' value=0 required></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRow'><span data-feather='trash'></span></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody').append(tr);
                feather.replace();
            });

            $('tbody').on('click', '.deleteRow', function(){
                $(this).parent().parent().remove();
            });

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
                                    "<option>kilogram(kg)</option>"+
                                    "<option>gram(gr)</option>"+
                                    "<option>liter(lt)</option>"+
                                    "<option>ekor</option>"+
                                    "<option>lembar</option>"+
                                "</select>"+
                            "</td>"+
                            "<td><input type='number' class='form-control priceID' name='price[]' value=0 required></td>"+
                            "<td><input type='number' class='form-control subtotalID' value=0 disabled></td>"+
                            "<td>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRowPurchase'><span data-feather='trash'></span></a>"+
                            "</td>"+
                        "</tr>"
                $('tbody').append(tr);
                feather.replace();
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

            $( '.single-select-employee' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                allowClear: true
            } );
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
            $( '.single-select-menu-type' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                
            } );

            function deleteData(url, id) {
                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            $('#success_hapus').removeClass('d-none').html('Data Barang Berhasil Dihapus, Silahkan Tunggu...').addClass('show');

                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            }

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
    
</body>

</html>
