@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Buat Catatan Gaji Karyawan</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/salary" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3">
                        <label for="emp_name" class="form-label @error('emp_name') is-invalid @enderror">Nama</label>
                        <select class="form-select single-select-employee" name="user_id" id="emp_name" data-placeholder="Pilih Karyawan" required>
                            <option></option>
                            @foreach ($employee as $emp)
                                @if(old('emp_name') == $emp->id)
                                    <option value="{{ $emp->id }}" selected>{{ $emp->name }}</option>
                                @else
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('emp_name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="salary" class="form-label @error('salary') is-invalid @enderror">Jumlah</label>
                        <input type="hidden" class="form-control" id="name" name="name" value="{{ $emp->name }}">
                        <input type="hidden" class="form-control" id="email" name="email" value="{{ $emp->email }}">
                        <input type="hidden" class="form-control" id="telp" name="telp" value="{{ $emp->telp }}">
                        <input type="number" class="form-control" id="salary" name="salary"
                            value="{{ old('salary') }}" required>
                        @error('salary')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mb-3 mt-2">Tambah Upah Karyawan</button>
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
                allowClear: true
            } );
            
        });
    </script>
@endpush
