@extends('dashboard.layouts.main')

@section('container')
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Rekapitulasi Transaksi</h4></div>
            </div>
        </div>
        <div class="card-body">
            <form action="/transactions-recap-validate-false" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6">
                        <label for="start_date" class="form-label @error('start_date') is-invalid @enderror">Tanggal Awal Transaksi<span class="text-danger">*</span></label>
                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Masukan tanggal awal dan akhir yang sama jika ingin melihat rekap transaksi pada satu hari kerja"></i>
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date') }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Masukan tanggal awal transaksi!')" oninput="this.setCustomValidity('')">
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 col-sm-12 col-md-6 col-lg-6">
                        <label for="end_date" class="form-label @error('end_date') is-invalid @enderror">Tanggal Akhir Transaksi<span class="text-danger">*</span></label>
                        <i class="fas fa-question-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Masukan tanggal awal dan akhir yang sama jika ingin melihat rekap transaksi pada satu hari kerja"></i>
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ old('end_date') }}" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninvalid="this.setCustomValidity('Masukan tanggal akhir transaksi!')" oninput="this.setCustomValidity('')">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                </div>
                <button id="download-pdf-btn" type="submit" class="btn btn-primary mb-3 mt-2"><i class="fas fa-eye mr-2"></i></i>Lihat Rekap Transaksi</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            $('#download-pdf-btn').on('click', function(event) {
                event.preventDefault();

                $.ajax({
                    url: '/transactions-recap-validate',
                    method: 'POST',
                    data: {
                        "_token": '{{ csrf_token() }}',
                        "start_date": $('#start_date').val(),
                        "end_date": $('#end_date').val(),
                    },
                    success: function(data) {
                        if (data.valid) {
                            var startDate = $('#start_date').val();
                            var endDate = $('#end_date').val();
                            var token = '{{ csrf_token() }}';
                            var url = '/transactions-recap-download?_token='+ token +'&start_date=' + startDate + '&end_date=' + endDate;
                            window.open(url, '_blank');
                        } else {
                            $('form').submit();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endpush
