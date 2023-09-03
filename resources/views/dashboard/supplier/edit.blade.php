@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb no-bg">
                <li class="breadcrumb-item"><a href="/supplier">Daftar Pemasok</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubah Pemasok</li>
            </ol>
        </nav>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <div class="row">
                <div class="col"><h4 class="font-weight-bold">Ubah Data Pemasok</h4></div>
            </div> 
        </div>
        <div class="card-body">
            <form action="/supplier/{{ $supplier->id }}" method="post">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label @error('supplier_name') is-invalid @enderror">Nama
                                Tempat Pemasok<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                value="{{ old('supplier_name',$supplier->supplier_name) }}" required autofocus oninvalid="this.setCustomValidity('Nama Tempat Pemasok tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label @error('description') is-invalid @enderror">Keterangan</label>
                            <textarea type="text" class="form-control" id="description" name="supplier_description">{{ old('supplier_description',$supplier->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label @error('address') is-invalid @enderror">Alamat
                                <span class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" id="address" name="address" required oninvalid="this.setCustomValidity('Alamat tidak boleh kosong !')" oninput="this.setCustomValidity('')">{{ old('address',$supplier->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="responsible"
                                class="form-label @error('responsible') is-invalid @enderror">Pemilik<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="responsible" name="responsible"
                                value="{{ old('responsible',$supplier->responsible) }}" required oninvalid="this.setCustomValidity('Nama Pemilik tidak boleh kosong !')" oninput="this.setCustomValidity('')">
                            @error('responsible')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP<span class="text-danger">*</span> Cth: 62878***</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                value="{{ old('telp',$supplier->telp) }}" required oninvalid="this.setCustomValidity('Nomor Telepon tidak boleh kosong !')" onkeypress="return event.charCode >= 48 && event.charCode <= 57" oninput="this.setCustomValidity('')">
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mb-3"><i class="fas fa-pen mr-2"></i>Ubah Data Pemasok</button>
                    </div>
                </form>
                </div>
                <div class="row mt-2">
                    <h4 class="fw-bold">Rincian Produk</h4>
                    @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    
                    <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="success_hapus">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="table-responsive mt-2">
                        <table class="table" id="editTable">
                            <thead>
                                <tr>
                                    <th scope="col" width="30%">Nama<span class="text-danger">*</span></th>
                                    <th scope="col" width="40%">Keterangan</th>
                                    <th scope="col" width="20%">Harga<span class="text-danger">*</span></th>
                                    <th scope="col" width="10%">
                                        <div  class="d-flex justify-content-end">
                                            <a href="javascript:void(0)" class="btn btn-success addRow"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($stuffs as $stuff)

                                    <tr data-id="{{ $stuff->id }}" data-supplier-id="{{ $supplier->id }}">
                                        <td>
                                            <input type="text" class="form-control-plaintext stuff-name" name="stuff_name" value="{{ $stuff->stuff_name }}" id="validationServerStuff" aria-describedby="inputGroupPrepend3 validationServerStuffFeedback" required readonly>
                                            <div id="validationServerStuffFeedback" class="invalid-feedback d-none">
                                                Silahkan simpan data terlebih dahulu
                                              </div>
                                        </td>
                                        <td><textarea class="form-control-plaintext stuff-desc" name="description" readonly>{{ $stuff->description }}</textarea></td>
                                        <td><input type="text" class="form-control-plaintext priceFormat" value="Rp. {{ number_format($stuff->price, 0, ',', '.') }}" readonly><input type="hidden" class="form-control-plaintext stuff-price" name="price" value="{{ $stuff->price }}" required readonly>
                                            
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between">

                                                <a class="btn btn-success button-save d-none col-sm-6 mr-1" ><i class="fas fa-check"></i></a>
                                                <a class="btn btn-warning button-edit col-sm-6 mr-1"><i class="fas fa-edit"></i></a>
                                                <a class="btn btn-danger button-cancel d-none col-sm-6"><i class="fas fa-times"></i></a>
                                                <a class="btn btn-danger single-stuff col-sm-6"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>

                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function(){
            $('thead').on('click', '.addRow', function(){
                var editButtonLoc = $('.button-edit');

                if(editButtonLoc.hasClass('d-none')){
                    var hiddenLoc = $('a.button-edit.d-none');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerStuffFeedback');
                    var stuffLoc = hiddenLoc.closest('tr').find('#validationServerStuff');

                    stuffLoc.addClass('is-invalid');
                    errorMSG.removeClass('d-none');
                } 
                else{
                    var tr = "<tr data-supplier-id='{{ $supplier->id }}'>"+
                            "<td><input type='text' class='form-control stuff-name' name='stuff_name' id='validationServerStuff' aria-describedby='inputGroupPrepend3 validationServerStuffFeedback' required >"+
                                "<div id='validationServerStuffFeedback' class='invalid-feedback d-none'>"+
                                    "Silahkan simpan data terlebih dahulu"+
                                "</div>"+
                            "</td>"+
                            "<td><textarea class='form-control stuff-desc' name='description' ></textarea></td>"+
                            "<td><input type='number' class='form-control stuff-price' name='price' required min='1'></td>"+
                            "<td>"+
                                "<div class='d-flex justify-content-between'>"+
                                    "<a class='btn btn-success button-save col-sm-6 mr-1'><i class='fas fa-check'></i></a>"+
                                    "<a class='btn btn-warning button-edit d-none col-sm-6'><i class='fas fa-edit'></i></a>"+
                                    "<a class='btn btn-danger button-cancel d-none col-sm-6'><i class='fas fa-times'></i></a>"+
                                    "<a href='javascript:void(0)' class='btn btn-danger col-sm-6 deleteRow'><i class='fas fa-trash-alt'></i></a>"+
                                "</div>"+
                            "</td>"+
                        "</tr>"
                    $('tbody').append(tr);
                    // feather.replace();
                }
                
            });

            $('tbody').on('click', '.deleteRow', function(){
                $(this).parent().parent().parent().remove();
            });

            $('#editTable').on('click', '.button-edit', function(){
                var editButtonLoc = $('.button-edit');

                if(editButtonLoc.hasClass('d-none')){
                    var hiddenLoc = $('a.button-edit.d-none');
                    var errorMSG = hiddenLoc.closest('tr').find('#validationServerStuffFeedback');
                    var stuffLoc = hiddenLoc.closest('tr').find('#validationServerStuff');

                    stuffLoc.addClass('is-invalid');
                    errorMSG.removeClass('d-none');
                } 
                else{
                    var saveButton = $(this).closest('td').find('a.button-save');
                    var editButton = $(this);
                    var cancelButton = $(this).closest('td').find('a.button-cancel');
                    var deleteButton = $(this).closest('td').find('a.single-stuff');
                    var inpName = editButton.closest('tr').find('input.stuff-name');
                    var inpDesc = editButton.closest('tr').find('textarea.stuff-desc');
                    var inpPrice = editButton.closest('tr').find('input.stuff-price');
                    var inpPriceFormat = editButton.closest('tr').find('input.priceFormat');

                    inpName.removeClass('form-control-plaintext');
                    inpName.removeAttr("readonly");
                    inpName.addClass('form-control');

                    inpDesc.removeClass('form-control-plaintext');
                    inpDesc.removeAttr("readonly");
                    inpDesc.addClass('form-control');

                    inpPrice.removeClass('form-control-plaintext');
                    inpPrice.removeAttr("readonly");
                    inpPrice.addClass('form-control');
                    inpPrice.attr('type','number');
                    inpPriceFormat.attr('type','hidden');

                    saveButton.removeClass('d-none');
                    cancelButton.removeClass('d-none');
                    editButton.addClass('d-none');
                    deleteButton.addClass('d-none');
                }
            });

            $('#editTable').on('click', '.button-save', function(e){
                e.preventDefault();

                var saveButton = $(this);
                var stuff_name = saveButton.closest('tr').find('input.stuff-name');
                var description = saveButton.closest('tr').find('textarea.stuff-desc');
                var price = saveButton.closest('tr').find('input.stuff-price');
                var value_stuff_name = stuff_name.val();
                var value_description = description.val();
                var value_price = parseInt(price.val());
                var id = saveButton.parents("tr").attr("data-id");
                var supplier_id = saveButton.parents("tr").attr("data-supplier-id");
                
                $.ajax({
                    url: '{{ route('update.stuff') }}',
                    type: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": id,
                        "supplier_id": supplier_id,
                        "stuff_name" : value_stuff_name,
                        "description" : value_description,
                        "price" : value_price,
                    },
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(response) {
                        let keyname;
                        console.log('Sekarang error')
                        $.each(response.responseJSON.errors, function(key, value){
                            keyname = key;
                            keymessage = value;
                        });
                        console.log(response.responseJSON);
                        stuff_name.closest('td').find('.invalid-feedback').empty();
                        stuff_name.removeClass('is-invalid');
                        price.closest('td').find('.invalid-feedback').empty();
                        price.removeClass('is-invalid');
                        if (keyname == stuff_name.attr('name')){
                            stuff_name.addClass('is-invalid');
                            stuff_name.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        if (keyname == price.attr('name')){
                            price.addClass('is-invalid');
                            price.closest('td').append("<div class='invalid-feedback'>"+keymessage+"</div>");
                        }
                        
                    }
                });

            });

            $('#editTable').on('click', '.button-cancel', function(e){
                e.preventDefault();
                window.location.reload();
            });

            $('#editTable').on('click', '.single-stuff', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var url = `{{ url('/stuff/${id}') }}`;

                Swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {
                                "id": id,
                                "_token": $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function () {
                                Swal.fire({
                                    title:'Terhapus!',
                                    text:'Data telah dihapus.',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer:'1500'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
            
        });
    </script>
@endpush
