@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Ubah Data Pemasok</h1>
    </div>
    <div class="card col-lg-8">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="/supplier/{{ $supplier->id }}" method="post">
                @method('put')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="supplier_name" class="form-label @error('supplier_name') is-invalid @enderror">Nama
                                Tempat Pemasok</label>
                            <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                value="{{ old('supplier_name',$supplier->supplier_name) }}" required autofocus>
                            @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label @error('description') is-invalid @enderror">Deskripsi
                                Pemasok</label>
                            <textarea type="text" class="form-control" id="description" name="supplier_description"
                             required>{{ old('supplier_description',$supplier->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label @error('address') is-invalid @enderror">Alamat
                                Pemasok</label>
                            <textarea type="text" class="form-control" id="address" name="address" required>{{ old('address',$supplier->address) }}</textarea>
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
                                class="form-label @error('responsible') is-invalid @enderror">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="responsible" name="responsible"
                                value="{{ old('responsible',$supplier->responsible) }}" required>
                            @error('responsible')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="telp" class="form-label @error('telp') is-invalid @enderror">No. HP</label>
                            <input type="text" class="form-control" id="telp" name="telp"
                                value="{{ old('telp',$supplier->telp) }}" required>
                            @error('telp')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mb-3">Selesai</button>
                    </div>
                </form>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="alert alert-success alert-dismissible fade d-none" role="alert" id="success_hapus">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <table class="table table-light" id="editTable">
                            <thead>
                                <tr>
                                    <th scope="col">Nama Bahan</th>
                                    <th scope="col">Deskripsi</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">
                                        <div  class="d-flex justify-content-center">
                                            <a href="javascript:void(0)" class="btn btn-success addRow">+</a>
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
                                        <td><input type="number" class="form-control-plaintext stuff-price" name="price" value="{{ $stuff->price }}" required readonly>
                                            
                                        </td>
                                        <td>
                                            <a class="btn btn-success button-save d-none" ><span data-feather='check'></span></a>
                                            <a class="btn btn-warning button-edit"><span data-feather='edit'></span></a>
                                            <a class="btn btn-danger single-stuff"><span data-feather='trash'></span></a>
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
                var select_stuff = $('.single-stuff').last();
                var editButton = select_stuff.closest('td').find('a.button-edit');
                var saveButton = select_stuff.closest('td').find('a.button-save');
                var stuffExist = $('#validationServerStuff');

                if(editButton.hasClass('d-none')){
                    var errorMSG = select_stuff.closest('tr').find('#validationServerStuffFeedback');
                    var stuffLoc = select_stuff.closest('tr').find('#validationServerStuff');

                    stuffLoc.addClass('is-invalid');
                    errorMSG.removeClass('d-none');
                } 
                else{
                    var tr = "<tr data-supplier-id='{{ $supplier->id }}'>"+
                            "<td><input type='text' class='form-control stuff-name' name='stuff_name' id='validationServerStuff' aria-describedby='inputGroupPrepend3 validationServerStuffFeedback' required>"+
                                "<div id='validationServerStuffFeedback' class='invalid-feedback d-none'>"+
                                    "Silahkan simpan data terlebih dahulu"+
                                "</div>"+
                            "</td>"+
                            "<td><textarea class='form-control stuff-desc' name='description' ></textarea></td>"+
                            "<td><input type='number' class='form-control stuff-price' name='price' required></td>"+
                            "<td>"+
                                "<a class='btn btn-success button-save'><span data-feather='check'></span></a>"+
                                "<a class='btn btn-warning button-edit d-none'><span data-feather='edit'></span></a>"+
                                "<a href='javascript:void(0)' class='btn btn-danger deleteRow single-stuff'><span data-feather='trash'></span></a>"+
                            "</td>"+
                        "</tr>"
                    $('tbody').append(tr);
                    feather.replace();
                }
                
            });

            $('tbody').on('click', '.deleteRow', function(){
                $(this).parent().parent().remove();
            });

            $('#editTable').on('click', '.button-edit', function(){
                var saveButton = $(this).closest('td').find('a.button-save');
                var editButton = $(this);
                var inpName = editButton.closest('tr').find('input.stuff-name');
                var inpDesc = editButton.closest('tr').find('textarea.stuff-desc');
                var inpPrice = editButton.closest('tr').find('input.stuff-price');

                inpName.removeClass('form-control-plaintext');
                inpName.removeAttr("readonly");
                inpName.addClass('form-control');

                inpDesc.removeClass('form-control-plaintext');
                inpDesc.removeAttr("readonly");
                inpDesc.addClass('form-control');

                inpPrice.removeClass('form-control-plaintext');
                inpPrice.removeAttr("readonly");
                inpPrice.addClass('form-control');

                saveButton.removeClass('d-none');
                editButton.addClass('d-none');
            });

            //lanjut validasi error
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
                        "price" : value_price
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
                        price.closest('td').find('.invalid-feedback').empty();
                        stuff_name.removeClass('is-invalid');
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

            $('#editTable').on('click', '.single-stuff', function(e){
                e.preventDefault();
                var id = $(this).parents("tr").attr("data-id");
                var url = `{{ url('/stuff/${id}') }}`;

                if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                    $.ajax({
                        url: url,
                        type: 'post',
                        data: {
                            "id": id,
                            "_token": $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                             window.location.reload();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
            
        });
    </script>
@endpush
