<div class="row">
    @forelse ($fnbs as $fnb)
    <div class="card mb-4 col-sm-6 col-md-6 col-lg-4">
        {{-- <div class=" col-sm-6 col-md-6 col-lg-4"> --}}
        <div class="productCard" data-cart-id={{ $fnb->id }}>
            <div class="view overlay">
            {{-- <a href="/pos/add-to-cart/{{ $fnb->id }}"></a> --}}
                <img class="card-img-top gambar" src="{{ asset('images/' . $fnb->image) }}" alt="Card image cap" style="cursor: pointer">
            </div>
            <div class="card-body">
            <label class="card-text font-weight-bold" style="text-transform: capitalize;">
                {{ Str::words($fnb->name, 4) }} </label>
            <p class="card-text text-center">Rp. {{ number_format($fnb->price, 0, ',', '.') }}
            </p>
            </div>
        </div>
        {{-- </div> --}}
    </div>
    @empty
    <p class="card-text text-center">Menu tidak ditemukan</p>
    @endforelse
</div>
<div class="justify-content-center">{{ $fnbs->links() }}</div>