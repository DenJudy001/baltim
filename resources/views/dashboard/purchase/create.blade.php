@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buat Pemesanan</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/purchase" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label @error('supplier_id') is-invalid @enderror">Pemasok</label>
                        <select class="form-select single-select-supplier" name="supplier_id" id="sel_supplier_id" data-placeholder="Pilih Pemasok" required>
                            <option></option>
                            @foreach ($suppliers as $supp)
                                <option value="{{ $supp->id }}">{{ $supp->supplier_name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        @if(session()->has('error_validate'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error_validate') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <table class="table table-light" id="PurchaseTable">
                            <thead>
                                <tr>
                                    <th scope="col" nowrap>Nama Bahan</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col" nowrap>Sub Total</th>
                                    <th scope="col"><a href="javascript:void(0)" class="btn btn-success addRowPurchase">+</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select single-select-stuff" data-placeholder="Pilih Barang" name="stuff_name[]" required>
                                            <option></option>
                                        </select>
                                    </td>
                                    <td><textarea  class="form-control descID" name="description[]" required></textarea></td>
                                    <td><input type="number" class="form-control qtyID" name="qty[]" value=1 required></td>
                                    <td>
                                        <select class="form-select single-select-unit" data-placeholder="Pilih Satuan" name="unit[]" required>
                                            <option></option>
                                            <option>kilogram(kg)</option>
                                            <option>gram(gr)</option>
                                            <option>liter(lt)</option>
                                            <option>ekor</option>
                                            <option>lembar</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control priceID" name="price[]" value=0 required></td>
                                    <td><input type="number" class="form-control subtotalID" value=0 disabled></td>
                                    <td>
                                        {{-- <a href="javascript:void(0)" class="btn btn-danger deleteRowPurchase"><span data-feather='trash'></span></a> --}}
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr >
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td ><div class="d-flex justify-content-end">Total Harga :</div></td>
                                    <td colspan="2"><input type="number" class="form-control-plaintext text-left" name="total" id="totalPurchase" value="0" readonly></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3">Buat Pemesanan</button>
            </form>
        </div>
    </div>
@endsection
