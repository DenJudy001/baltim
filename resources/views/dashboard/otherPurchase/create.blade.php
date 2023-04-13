@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Buat Catatan Pembayaran</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/otherpurchase" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="purchase_name" class="form-label @error('purchase_name') is-invalid @enderror">Nama Pembayaran<span class="text-danger">*</span><span> Cth: Listrik,Peralatan,Transportasi,dsb..</span></label>
                        <input type="text" class="form-control" id="purchase_name" name="purchase_name"
                            value="{{ old('purchase_name') }}" required autofocus oninvalid="this.setCustomValidity('Nama Pembayaran tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('purchase_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label @error('description') is-invalid @enderror">Keterangan</label>
                        <textarea type="text" class="form-control" id="description" name="supplier_description"
                            value="{{ old('supplier_description') }}"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label @error('total') is-invalid @enderror">Total Harga<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="total" name="total"
                            value="{{ old('total') }}" required min='1' onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Harga tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Buat Catatan Pembayaran</button>
            </form>
        </div>
    </div>
@endsection