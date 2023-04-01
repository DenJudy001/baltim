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
        <div class="col-md-6 mb-4 col-lg-8">
            <div class="card" style="min-height:85vh">
                <div class="card-header bg-white">
                    <form action="/" method="get">
                        <div class="row">
                            <div class="col">
                                <h4 class="font-weight-bold">Menu</h4>
                            </div>
                            <div class="col text-right">
                                <select name="" id="" class="form-control from-control-sm" style="font-size: 12px">
                                    <option value="" holder>Filter Category</option>
                                    <option value="1">All Category...</option>
                                    <!-- Kembangkan sendiri ya bagian ini kalau bisa pake select2 biar keren -->
                                </select>
                            </div>
                            <div class="col"><input type="text" name="search"
                                    class="form-control form-control-sm col-sm-12 float-right"
                                    placeholder="Cari Menu..." onblur="this.form.submit()"></div>
                            <div class="col-sm-3"><button type="submit"
                                    class="btn btn-primary btn-sm float-right btn-block">Cari Menu</button></div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($fnbs as $fnb)
                        <div style="width: 16.66%;border:1px solid rgb(243, 243, 243)" class="mb-4">
                            <div class="productCard">
                                <div class="view overlay">
                                    <a href="/pos/add-to-cart/{{ $fnb->id }}"><img class="card-img-top gambar" src="{{ asset('images/'.$fnb->image) }}"
                                        alt="Card image cap" style="cursor: pointer"></a>
                                    
                                </div>
                                <div class="card-body">
                                    <label class="card-text text-center font-weight-bold"
                                        style="text-transform: capitalize;">
                                        {{ Str::words($fnb->name,4) }} </label>
                                    <p class="card-text text-center">Rp. {{ number_format($fnb->price,0,',','.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-center">{{ $fnbs->links() }}</div>
            </div>
            {{-- <div class="mb-2">
                <input
                    type="text"
                    class="form-control search"
                    placeholder="Search Product..."
                />
            </div>
            <div class="order-product product-search" style="display: flex;column-gap: 0.5rem;flex-wrap: wrap;row-gap: .5rem;">
                @foreach($products as $product)
                    <button type="button"
                        class="item"
                        style="cursor: pointer; border: none;"
                        value="{{ $product->id }}"
                    >
                        @if($product->image)
                        <img src="{{ $product->image->getUrl() }}" width="45px" height="45px" alt="test" />
                        @endif
                        <h6 style="margin: 0;">{{ $product->name }}</h6>
                        <span >(${{ $product->price }})</span>
                    </button>
                @endforeach
            </div> --}}
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="user-cart">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="30%">Menu</th>
                                <th width="20%">Jumlah</th>
                                <th class="text-right" width="40%">Harga</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(session('cart'))
                                @foreach(session('cart') as $menu => $details)
                                <tr data-id="{{ $menu }}">
                                    <td>{{Str::words($details['name'],2)}}</td>
                                    <td class="font-weight-bold">
                                        <input type="number" class="form-control qty update-qty" value={{ $details['quantity'] }} required>
                                    </td>
                                    <td class="text-right">Rp. {{ number_format($details['price'],0,',','.') }}</td>
                                    <td><button class="badge bg-danger border-0 remove-from-cart"><span data-feather="trash"></span></button></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <form action="/pos" method="post">
                @csrf 
                <div class="row mt-2">
                    @php $total = 0 @endphp
                    @foreach((array) session('cart') as $menu => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                    @endforeach
                    <div class="col">Total:</div>
                    <div class="col text-right">
                        <p><span class="text-dark">Rp. {{ number_format($total,0,',','.') }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button
                            type="button"
                            class="btn btn-danger btn-block"
                        >
                            Cancel
                        </button>
                    </div>
                    <div class="col">
                        <button
                            type="submit"
                            class="btn btn-primary btn-block"
                        >
                            Pay
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $(".update-qty").change(function (e) {
                e.preventDefault();
        
                var position = $(this);
                var id = position.parents("tr").attr("data-id");
                var quantity = position.parents("tr").find(".qty").val();
                var url = "{{ URL::to('pos/update-qty/') }}";
        
                $.ajax({
                    url: url,
                    type: 'post',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'), 
                        "id": id, 
                        "quantity": quantity
                    },
                    success: function (response) {
                        // console.log(url,id,quantity);
                        window.location.reload();
                    },
                    // error: function(error){
                    //     console.log(error);
                    // }
                });
            });

            $(".remove-from-cart").click(function (e) {
                e.preventDefault();
        
                var position = $(this);
        
                if(confirm("Apakah Anda yakin ingin menghapus menu?")) {
                    $.ajax({
                        url: '{{ route('remove.from.cart') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}', 
                            id: position.parents("tr").attr("data-id")
                        },
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
    
@endpush