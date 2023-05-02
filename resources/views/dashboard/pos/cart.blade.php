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