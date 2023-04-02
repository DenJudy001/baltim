@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Catatan Pembayaran</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/otherpurchase" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="purchase_name" class="form-label @error('purchase_name') is-invalid @enderror">Nama Pembayaran</label>
                        <input type="text" class="form-control" id="purchase_name" name="purchase_name"
                            value="{{ old('purchase_name') }}" required autofocus>
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
                        <label for="total" class="form-label @error('total') is-invalid @enderror">Total Harga</label>
                        <input type="number" class="form-control" id="total" name="total"
                            value="{{ old('total') }}" required>
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