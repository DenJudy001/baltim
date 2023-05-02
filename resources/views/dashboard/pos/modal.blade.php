@php $total = 0 @endphp
@foreach ((array) session('cart') as $menu => $details)
    @php $total += $details['price'] * $details['quantity'] @endphp
@endforeach
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