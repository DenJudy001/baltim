<div class="row">
    @forelse ($fnbs as $fnb)
    <div class="card mb-4 col-sm-6 col-md-6 col-lg-4 p-0 productCard d-flex flex-column" data-cart-id={{ $fnb->id }}>
        <div class="view overlay flex-grow-1" style="cursor: pointer">
            <img class="card-img-top gambar" src="{{ asset('images/' . $fnb->image) }}" alt="Card image cap">
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
    @empty
    <p class="card-text text-center">Menu tidak ditemukan</p>
    @endforelse
</div>
<div class="justify-content-center">{{ $fnbs->links() }}</div>