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
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <select name="category_type" id="sel_category_id" class="form-select form-select-sm single-select-category" data-placeholder="Pilih Kategori"
                                        style="font-size: 12px">
                                        <option></option>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($fnbCat as $fnbcat)
                                        <option {{ request('category_type') == $fnbcat->type ? 'selected' : '' }}>{{ $fnbcat->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-8 mb-2"><input type="text" name="search"
                                        class="form-control form-control-sm col-sm-12 float-right search"
                                        placeholder="Cari Menu..." value="{{ request('search') }}"></div>
                                {{-- <div class="col-lg-4"><button type="submit"
                                        class="btn btn-primary btn-sm float-right btn-block">Cari Menu</button></div> --}}
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
                            <div class="card mb-4 col-sm-6 col-md-6 col-lg-4">
                                <div class="productCard" data-cart-id={{ $fnb->id }}>
                                    <div class="view overlay">
                                        <img class="card-img-top gambar" src="{{ asset('images/' . $fnb->image) }}" alt="Card image cap" style="cursor: pointer">
                                    </div>
                                    <div class="card-body">
                                    <label class="card-text font-weight-bold" style="text-transform: capitalize;">
                                        {{ Str::words($fnb->name, 4) }} </label>
                                    <p class="card-text text-center">Rp. {{ number_format($fnb->price, 0, ',', '.') }}
                                    </p>
                                    </div>
                                </div>
                            </div>
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
                                            <label for="responsible" class="form-label">Kasir</label>
                                            <p id="responsible" class="fw-bold">{{ auth()->user()->name }}</p>
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
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
            if($(".table-cart tbody tr").length > 0) {
                $('div.save-reset-control').removeClass('d-none');
                
            } else {
                $('div.save-reset-control').addClass('d-none');
            }
            $( '.single-select-category' ).select2( {
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

            $("#search-control").on('keyup', '.search', function(e) {
                e.preventDefault();

                let search = $(this).val();
                let categ = $(".single-select-category").val();
                let url = "/pos/create";
                console.log(categ);

                if(categ != null){
                    url = "/pos/create?category_type="+categ+"&search="+search;
                } else {
                    url = "/pos/create?category_type=&search="+search;
                }

                find_menu(url);
                
            });
            
            $("#search-control").on('change', '.single-select-category', function(e) {
                e.preventDefault();

                let categ = $(this).val();
                let search = $("#search-control").find('.search').val();
                let url = "/pos/create";
                console.log(categ);

                if(search != null){
                    url = "/pos/create?category_type="+categ+"&search="+search;
                } else {
                    url = "/pos/create?category_type="+categ+"&search=";
                }

                find_menu(url);
            });

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                let categ = $("#search-control").find('.single-select-category').val();
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
