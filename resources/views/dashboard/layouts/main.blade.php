<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Baltim Resto | Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">
</head>

<body>

    @include('dashboard.layouts.partials.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.partials.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('container')
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>
    <script src="/assets/js/dashboard.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script>
        $('tfoot').on('click', '.addRow', function(){
            var tr = "<tr>"+
                        "<td><input type='text' class='form-control' id='stuff_name' name='stuff_name[]' required></td>"+
                        "<td><input type='text' class='form-control nowrap' id='description' name='description[]' required></td>"+
                        "<td><input type='text' class='form-control' id='price' name='price[]' required></td>"+
                        "<td>"+
                            "<a href='javascript:void(0)' class='btn btn-danger deleteRow'><span data-feather='trash'></span></a>"+
                        "</td>"+
                    "</tr>"
            $('tbody').append(tr);
            feather.replace();
        });

        $('tbody').on('click', '.deleteRow', function(){
            $(this).parent().parent().remove();
        });
    </script>
    <script>
        function deleteData(url, id) {
            if (confirm('Apakah Anda yakin ingin menghapus data yang sudah tersimpan?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#success_hapus').removeClass('d-none').html('Data Barang Berhasil Dihapus, Silahkan Tunggu...').addClass('show');

                        setTimeout(function(){
                            location.reload();
                        }, 2000);
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    </script>
    
</body>

</html>
