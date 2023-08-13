@extends('dashboard.layouts.main')

@section('container')
    <div class="container mt-5">
        <div class="row justify-content-center">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('success_create'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_create') }} Silahkan <a href="/pos/{{ session('pos_id') }}/edit">klik disini!</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="alert alert-danger alert-dismissible fade d-none" role="alert" id="alert-save-trx">
                Anda belum tambahkan menu pada keranjang
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="col-md-6 mb-4 col-lg-8">
                <div class="card">
                    <div class="card-header bg-white">
                        {{-- <form action="{{ url('/pos/create') }}" method="get"> --}}
                            <div class="row">
                                <div class="col">
                                    <h4 class="font-weight-bold">Menu</h4>
                                </div>
                            </div>
                            <div class="row mb-2" id="search-control">
                                <div class="row mb-2">
                                    <div class="col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" name="search" class="form-control form-control-sm col-sm-12 float-right search" placeholder="Cari Menu..." value="{{ request('search') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-8 col-lg-2">
                                        {{-- <select name="category_type" id="sel_category_id" class="form-select form-select-sm single-select-category" data-placeholder="Pilih Kategori"
                                            style="font-size: 12px">
                                            <option></option>
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($fnbCat as $fnbcat)
                                            <option {{ request('category_type') == $fnbcat->type ? 'selected' : '' }}>{{ $fnbcat->type }}</option>
                                            @endforeach
                                        </select> --}}
                                        <table class="table table-borderless table-sm w-auto">
                                            <tr>
                                                <td width="20%" class="pl-1">Kategori</td>
                                                <td width="5%">:</td>
                                                <td class="d-none">
                                                    <button type="button" class="btn btn-primary btn-sm float-left single-select-category"></button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-10">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm w-auto">
                                                <tr class="category-list">
                                                    @foreach ($fnbCat as $fnbcat)
                                                    <td>
                                                        <button type="button" class="btn btn-outline-primary btn-sm float-left category-select">{{ $fnbcat->type }}</button>
                                                    </td>
                                                    @endforeach
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4"><button type="button"
                                        class="btn btn-primary btn-sm float-right btn-block search-button">Cari Menu</button></div> --}}
                            </div>
                            {{-- <div class="row">
                                <div class="d-lg-none"><button type="submit"
                                    class="btn btn-primary btn-sm float-right btn-block">Cari Menu</button></div>
                            </div> --}}
                        {{-- </form> --}}
                    </div>
                    <div class="card-body d-flex flex-wrap justify-content-center menu-items">
                        <div class="row">
                            @foreach ($fnbs as $fnb)
                            {{-- <div class="card mb-4 col-sm-6 col-md-6 col-lg-4 p-0"> --}}
                                <div class="card mb-4 col-sm-6 col-md-6 col-lg-4 p-0 productCard d-flex flex-column" data-cart-id={{ $fnb->id }}>
                                    <div class="view overlay flex-grow-1" style="cursor: pointer">
                                        <img class="card-img-top gambar" src="{{ asset('images/' . $fnb->image) }}" alt="Card image cap" >
                                    </div>
                                    <div class="d-flex align-items-end">
                                        <div class="card-body p-3 bg-light mb-auto">
                                            <label class="card-text" style="text-transform: capitalize;">
                                                {{ Str::words($fnb->name, 4) }} </label>
                                            <p class="card-text font-weight-bold">Rp. {{ number_format($fnb->price, 0, ',', '.') }}
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            {{-- </div> --}}
                            @endforeach
                        </div>
                        <div class="justify-content-center mt-2">{{ $fnbs->links() }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="user-cart">
                    <div class="card mb-3 table-cart">
                        <table class="table mb-0 cart-table">
                            <thead>
                                <tr>
                                    <th width="30%">Menu</th>
                                    <th width="20%">Jumlah</th>
                                    <th class="text-right" width="40%">Harga</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (session('cart'))
                                    @foreach (session('cart') as $menu => $details)
                                        <tr data-id="{{ $menu }}">
                                            <td>{{ Str::words($details['name'], 2) }}</td>
                                            <td class="font-weight-bold">
                                                <input type="number" min="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" class="form-control qty update-qty"
                                                    value={{ $details['quantity'] }} required>
                                            </td>
                                            <td class="text-right">Rp. {{ number_format($details['price'], 0, ',', '.') }}</td>
                                            <td><button class="badge bg-danger border-0 remove-from-cart"><i class="fas fa-trash-alt"></i></button></td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                @php $total = 0 @endphp
                                @foreach ((array) session('cart') as $menu => $details)
                                    @php $total += $details['price'] * $details['quantity'] @endphp
                                @endforeach
                                <tr>
                                    <td>
                                        <div class="col font-weight-bold">Total :</div>
                                    </td>
                                    <td colspan="3">
                                        <div class="col text-right">
                                            <p><span class="font-weight-bold">Rp. {{ number_format($total, 0, ',', '.') }}</span></p>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- <div class="row mt-2">
                </div> --}}
                <div class="row save-reset-control d-none">
                    <div class="col">
                        <button type="button" class="btn btn-danger btn-block clear-cart">
                            Reset
                        </button>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#openTransaction">
                            Simpan Transaksi
                        </button>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="openTransaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Simpan Transaksi</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/pos" method="post">
                                @csrf
                            <div class="container-fluid">
                                <div class="card mb-4">
                                    <h5 class="card-header">
                                      Transaksi Penjualan
                                    </h5>
                                    <div class="card-body">
                                      <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <label for="selectState" class="form-label">Status Transaksi</label>
                                            <select name="state" id="selectState" class="form-select">
                                                <option value="Proses" selected>Proses</option>
                                                <option value="Selesai">Selesai</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label class="form-label">Kasir</label>
                                            <p class="fw-bold">{{ auth()->user()->name }}</p>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-modal">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-center" width="20%">Gambar</th>
                                                    <th scope="col" width="20%">Menu</th>
                                                    <th scope="col" width="30%">Keterangan</th>
                                                    <th scope="col" width="10%">Jumlah</th>
                                                    <th scope="col" class="text-right" width="20%">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (session('cart'))
                                                    @foreach (session('cart') as $menu => $details)
                                                        <tr>
                                                            <td scope="row"><img class="card-img-top"
                                                                src="{{ asset('images/' . $details['image']) }}" alt="Card image cap"></td>
                                                            <td>{{ $details['name'] }}</td>
                                                            <td>{{ $details['description'] }}</td>
                                                            <td class="font-weight-bold">
                                                                <p>{{ $details['quantity'] }}</p>
                                                            </td>
                                                            <td class="text-right">Rp. {{ number_format($details['price'], 0, ',', '.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>                                        
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">
                                                        <div class="d-flex justify-content-end">Total Harga :</div> 
                                                    </td>
                                                    <td>
                                                        <input type="hidden" value="{{ $total }}" name="totalHarga">
                                                        <div><span class="fw-bold">Rp. {{ number_format($total, 0, ',', '.') }}</span></div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times mr-2"></i>Batal</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check mr-2"></i>Simpan</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            var debounceTimer;
            var loadingCount = 0;

            if($(".table-cart tbody tr").length > 0) {
                $('div.save-reset-control').removeClass('d-none');
                
            } else {
                $('div.save-reset-control').addClass('d-none');
            }
            // $( '.single-select-category' ).select2( {
            //     theme: "bootstrap-5",
            //     width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            //     placeholder: $( this ).data( 'placeholder' ),
            //     allowClear: true,
            //     language: {
            //         "noResults": function(){
            //             return "Data Tidak ditemukan";
            //         }
            //     }
            // } );

            function find_menu(url){
                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // window.location.reload();
                        $('.menu-items').html(response);
                    }
                });
            }

            // $("#search-control").on('click', '.search-button', function(e) {
            //     e.preventDefault();
            //     performSearch();
            // });

            $("#search-control").on('keyup', '.search', function(e) {
                e.preventDefault();

                let search = $('.search').val();
                let categ = $(".single-select-category").text().trim();
                let url = "/pos/create";
                // console.log(categ);

                if(categ != null){
                    url = "/pos/create?category_type="+categ+"&search="+search;
                } else {
                    url = "/pos/create?category_type=&search="+search;
                }
                
                let html = '<div class="row">';
                if(loadingCount < 1){
                    for (var count = 0; count < 6; count++) {
                    html += '<div class="card mb-4 col-sm-6 col-md-6 col-lg-4" aria-hidden="true">';
                    html += '<div class="view overlay bg-secondary mt-1" aria-hidden="true">';
                    html += '<img class="card-img-top" src='+"{{ asset('images/') }}" + '/solid_gray.jpeg alt="Card image cap">';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h5 class="card-text placeholder-glow"><span class="placeholder col-6"></span></h5>';
                    html += '<p class="card-text placeholder-wave"><span class="placeholder col-4"></span></p>';
                    html += '</div>';
                    html += '</div>';
                    }
                    html += '</div>';
                    $('.menu-items').html(html);
                    loadingCount += 1;
                }
                            
                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }

                // Set timer baru untuk menjalankan fungsi find_menu setelah 0,5 detik
                debounceTimer = setTimeout(function() {
                    find_menu(url);
                    loadingCount = 0;
                }, 800);
                
            });

            // $("#search-control").on('keyup', '.search', function(e) {
            //     if (e.keyCode === 13) {
            //         e.preventDefault();
            //         performSearch();
            //     }
            // });

            //Filter kategori
            $("#search-control").on('click', '.category-select', function(e) {
                e.preventDefault();

                let categ = $(this).text().trim();
                let search = $("#search-control").find('.search').val();
                let url = "/pos/create";
                // console.log(categ);
                let categSelected = $("#search-control").find('.single-select-category');
                let newCategValue = categSelected.text().trim();

                if(newCategValue.length > 0){
                    let newCateg = $("#search-control").find('.category-list');
                    newCateg.append("<td>"+
                                        "<button type='button' class='btn btn-outline-primary btn-sm float-left category-select'>"+newCategValue+"</button>"+
                                    "</td>");
                }
                else {
                    $(this).parent().parent().prepend("<td class='ver-line'>|</td>");
                }

                categSelected.html(categ+" <i class='fas fa-times'></i>");
                categSelected.parent().removeClass("d-none");
                categSelected.parent().parent().parent().parent().parent().removeClass("col-lg-2");
                categSelected.parent().parent().parent().parent().parent().addClass("col-lg-5");
                $(this).parent().parent().parent().parent().parent().parent().addClass('col-lg-7');
                $(this).parent().parent().parent().parent().parent().parent().removeClass('col-lg-10');
                $(this).parent().remove();

                if(search != null){
                    url = "/pos/create?category_type="+categ+"&search="+search;
                } else {
                    url = "/pos/create?category_type="+categ+"&search=";
                }

                let html = '<div class="row">';
                if(loadingCount < 1){
                    for (var count = 0; count < 6; count++) {
                    html += '<div class="card mb-4 col-sm-6 col-md-6 col-lg-4" aria-hidden="true">';
                    html += '<div class="view overlay bg-secondary mt-1" aria-hidden="true">';
                    html += '<img class="card-img-top" src='+"{{ asset('images/') }}" + '/solid_gray.jpeg alt="Card image cap">';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h5 class="card-text placeholder-glow"><span class="placeholder col-6"></span></h5>';
                    html += '<p class="card-text placeholder-wave"><span class="placeholder col-4"></span></p>';
                    html += '</div>';
                    html += '</div>';
                    }
                    html += '</div>';
                    $('.menu-items').html(html);
                    loadingCount += 1;
                }

                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }

                // Set timer baru untuk menjalankan fungsi find_menu setelah 0,5 detik
                debounceTimer = setTimeout(function() {
                    find_menu(url);
                    loadingCount = 0;
                }, 300);
            });

            //Hapus filter kategori
            $("#search-control").on('click', '.single-select-category', function(e) {
                e.preventDefault();

                let categ = $(this).text().trim();
                let search = $("#search-control").find('.search').val();
                let url = "/pos/create";
                // console.log(categ);
                let categoryList = $("#search-control").find('.category-list');
                let line = $("#search-control").find('.ver-line');

                if(categ.length > 0){
                    let newCateg = $("#search-control").find('.category-list');
                    newCateg.append("<td>"+
                                        "<button type='button' class='btn btn-outline-primary btn-sm float-left category-select'>"+categ+"</button>"+
                                    "</td>");
                    line.remove();
                }

                categoryList.parent().parent().parent().parent().removeClass('col-lg-7');
                categoryList.parent().parent().parent().parent().addClass('col-lg-10');
                $(this).parent().addClass('d-none');
                $(this).html("");
                $(this).parent().parent().parent().parent().parent().removeClass('col-lg-5');
                $(this).parent().parent().parent().parent().parent().addClass('col-lg-2');

                if(search != null){
                    url = "/pos/create?category_type=&search="+search;
                } else {
                    url = "/pos/create?category_type=&search=";
                }

                let html = '<div class="row">';
                if(loadingCount < 1){
                    for (var count = 0; count < 6; count++) {
                    html += '<div class="card mb-4 col-sm-6 col-md-6 col-lg-4" aria-hidden="true">';
                    html += '<div class="view overlay bg-secondary mt-1" aria-hidden="true">';
                    html += '<img class="card-img-top" src='+"{{ asset('images/') }}" + '/solid_gray.jpeg alt="Card image cap">';
                    html += '</div>';
                    html += '<div class="card-body">';
                    html += '<h5 class="card-text placeholder-glow"><span class="placeholder col-6"></span></h5>';
                    html += '<p class="card-text placeholder-wave"><span class="placeholder col-4"></span></p>';
                    html += '</div>';
                    html += '</div>';
                    }
                    html += '</div>';
                    $('.menu-items').html(html);
                    loadingCount += 1;
                }

                if (debounceTimer) {
                    clearTimeout(debounceTimer);
                }

                // Set timer baru untuk menjalankan fungsi find_menu setelah 0,5 detik
                debounceTimer = setTimeout(function() {
                    find_menu(url);
                    loadingCount = 0;
                }, 300);
            });

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                let categ = $("#search-control").find('.single-select-category').text().trim();
                let search = $("#search-control").find('.search').val();
                if(search != null && categ != null){
                    url = "/pos/create?category_type="+categ+"&search="+search+"&page="+page;
                } else {
                    if(categ != null){
                        url = "/pos/create?category_type="+categ+"&search=";
                    }
                    else if(search != null){
                        url = "/pos/create?category_type=&search="+search+"&page="+page;
                    }
                    else {
                        url = "/pos/create?category_type=&search=&page="+page;
                    }
                }
                find_menu(url);
            });

            $(document).on('click','.productCard',function(e) {
                e.preventDefault();

                var position = $(this);
                let id = position.attr("data-cart-id")

                $.ajax({
                    url: "/pos/add-to-cart/"+id,
                    method: "GET",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // window.location.reload();
                        $('.table-cart').html(response.cart_view);
                        $('.table-modal').html(response.modal_view);
                        if($(".table-cart tbody tr").length > 0) {
                            $('div.save-reset-control').removeClass('d-none');
                            
                        } else {
                            $('div.save-reset-control').addClass('d-none');
                        }
                    }
                });
            });

            $(document).on('input', '.update-qty', function(e){
                e.preventDefault();

                var position = $(this);
                var id = position.parents("tr").attr("data-id");
                var quantity = parseInt(position.val());
                var url = "{{ URL::to('pos/update-qty/') }}";
                // console.log(position.val());
                if(quantity == 0){
                    quantity = 1;
                }
                if (quantity){
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            "id": id,
                            "quantity": quantity
                        },
                        success: function(response) {
                            // console.log(url,id,quantity);
                            // window.location.reload();
                            // $('.table-cart').html("");
                            $('.table-cart').html(response.cart_view);
                            $('.table-modal').html(response.modal_view);
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });

                }
            });

            $(document).on('click', '.remove-from-cart', function(e){
                e.preventDefault();

                var position = $(this);

                if (confirm("Apakah Anda yakin ingin menghapus menu pada keranjang?")) {
                    $.ajax({
                        url: '{{ route('remove.from.cart') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: position.parents("tr").attr("data-id")
                        },
                        success: function(response) {
                            // window.location.reload();
                            $('.table-cart').html(response.cart_view);
                            $('.table-modal').html(response.modal_view);

                            if($(".table-cart tbody tr").length > 0) {
                                $('div.save-reset-control').removeClass('d-none');
                                
                            } else {
                                $('div.save-reset-control').addClass('d-none');
                            }
                        }
                    });
                }
            });
            $(".clear-cart").click(function(e) {
                e.preventDefault();

                if (confirm("Apakah Anda yakin ingin menghapus semua keranjang?")) {
                    $.ajax({
                        url: '{{ route('clear.cart') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // window.location.reload();
                            $('.table-cart').html(response.cart_view);
                            $('.table-modal').html(response.modal_view);

                            if($(".table-cart tbody tr").length > 0) {
                                $('div.save-reset-control').removeClass('d-none');
                                
                            } else {
                                $('div.save-reset-control').addClass('d-none');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
