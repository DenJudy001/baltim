@extends('dashboard.layouts.main')

@section('container')
    <div class="alert alert-danger alert-dismissible fade d-none" role="alert" id="otherPurchaseAlert">
        <b>Perhatian!</b> disarankan untuk memilih menu <b>Pemesanan Bahan</b>, agar lebih detail.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
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
                        <label for="purchase_name" class="form-label @error('purchase_name') is-invalid @enderror">Jenis Pembayaran<span class="text-danger">*</span></label>
                        <select class="form-select single-select-purchase-name" data-placeholder="Pilih Jenis Pembayaran"
                            name="purchase_name" id="purchase_name" required>
                            <option></option>
                            <option value="Listrik">Listrik</option>
                            <option value="Air">Air</option>
                            <option value="Internet">Internet</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Asuransi">Asuransi</option>
                            <option value="Perawatan/Perbaikan">Perawatan/Perbaikan</option>
                            <option value="Pemasaran/Promosi">Pemasaran/Promosi</option>
                            <option value="Sewa Tempat">Sewa</option>
                        </select>
                        @error('purchase_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label @error('description') is-invalid @enderror">Keterangan</label>
                        <textarea type="text" class="form-control" id="description" name="supplier_description" placeholder="Cth: Pembayaran listrik untuk bulan januari"
                            value="{{ old('supplier_description') }}"></textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="total" class="form-label @error('total') is-invalid @enderror">Total Harga<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="total" name="total" placeholder="Cth: 100000"
                            value="{{ old('total') }}" required min='1' onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Harga tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('total')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-receipt mr-2"></i>Buat Catatan Pembayaran</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $( '.single-select-purchase-name' ).select2( {
                theme: "bootstrap-5",
                width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
                placeholder: $( this ).data( 'placeholder' ),
                sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
                tags : true
            } );

            $(".single-select-purchase-name").change(function(){
                var selectedValue = $(this).val();
                var alertposition = $('#otherPurchaseAlert');
                console.log(selectedValue);
                if(selectedValue == 'Persediaan Bahan'){
                    alertposition.removeClass('d-none');
                    alertposition.addClass('show');
                } else{
                    alertposition.removeClass('show');
                    alertposition.addClass('d-none');
                }
            });
            
        });
    </script>
@endpush