@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Pembayaran Gaji Karyawan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/salary" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="user_id" class="form-label @error('user_id') is-invalid @enderror">Nama<span class="text-danger">*</span></label>
                        <select class="form-select single-select-employee" name="user_id" id="user_id" data-placeholder="Pilih Karyawan" required oninvalid="this.setCustomValidity('Nama tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            <option></option>
                            @foreach ($employee as $emp)
                                @if(old('user_id') == $emp->id)
                                    <option value="{{ $emp->id }}" selected>{{ $emp->name }}</option>
                                @else
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label @error('salary') is-invalid @enderror">Jumlah<span class="text-danger">*</span></label>
                        <input type="hidden" class="form-control" id="name" name="name" value="{{ $emp->name }}">
                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $emp->email }}">
                        <input type="hidden" class="form-control" id="telp" name="telp" value="{{ $emp->telp }}">
                        <input type="number" class="form-control input-total-salary" id="salary" name="salary"
                            value="{{ old('salary',0) }}" required min="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Jumlah tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                        @error('salary')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-hand-holding-usd mr-2"></i>Buat Catatan Pembayaran</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $( '.single-select-employee' ).select2( {
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


            $('.single-select-employee').on('change', function(){
                var id = $(this).val();
                var url = "{{ URL::to('saldetails-dropdown') }}";
                var salary = $('#salary');
                
                $.ajax({
                    url : url,
                    type: 'GET',
                    data: {
                        "id" : id,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data){
                        salary.val(data.salary);
                    },
                    error: function(data){
                        // console.log('Error:', data);
                    }
                }) 
            });
            
        });
    </script>
@endpush
