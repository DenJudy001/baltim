<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembelian</title>

    <?php
    $style = '
    <style>
        * {
            font-family: "consolas", sans-serif;
        }
        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }
        table td {
            font-size: 9pt;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }

        table { page-break-inside:auto }
        div   { page-break-inside:avoid; } /* This is the key */
        thead { display:table-header-group }
        tfoot { display:table-footer-group }

        @media print {
            @page {
                margin: 0;
                size: 75mm 145mm;
            }
    ';
    ?>
    <?php
    $style .= '
            html, body {
                width: 70mm;
            }
            .btn-print {
                display: none;
            }
        }
    </style>
    ';
    ?>

    {!! $style !!}
    
</head>
<body onload="window.print()">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Cetak</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">RM-Baltim</h3>
        <p>Jl. Raya Serang No. 21, Cibadak, Kec. Cikupa, Kabupaten Tangerang, Banten 15710</p>
    </div>
    <br>
    <div>
        <p style="float: left;">Tgl: {{ date('d-m-Y') }}</p>
        <p style="float: right">Kasir: {{ strtoupper(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>No: {{ $pos->pos_number}}</p>
    <p class="text-center">===================================</p>
    
    <br>
    <table width="100%" style="border: 0;">
        @foreach ($pos->dtl_pos as $pos_detail)
            <tr>
                <td colspan="3">{{ $pos_detail->name }}</td>
            </tr>
            <tr>
                <td>{{ $pos_detail->qty }} x {{ $pos_detail->price }}</td>
                <td></td>
                <td class="text-right">Rp. {{number_format($pos_detail->qty * $pos_detail->price, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga:</td>
            <td class="text-right">Rp. {{number_format($pos->total, 0, ',', '.')}}</td>
        </tr>
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        var elem = document.documentElement;
        var height = elem.offsetHeight;
        var calHeight = (height + 50);
        console.log("tinggi = "+calHeight);

        var pageWidth = '75mm';
        var pageHeight = calHeight + 'px';
        var style = '@page { size: ' + pageWidth + ' ' + pageHeight + '; }';
        var newStyle = document.createElement('style');
        newStyle.appendChild(document.createTextNode(style));
        document.head.appendChild(newStyle);
    </script>
</body>
</html>