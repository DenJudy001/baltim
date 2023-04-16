<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Posisi Keuangan</title>
    <style type="text/css">
        table {
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10pt;
            text-align: left;
        }

        table th,
        td {
            border-bottom: 1px solid #ddd;
        }

        table th {
            border-top: 1px solid #ddd;
            height: 40px;
        }

        table td {
            height: 25px;
        }
        h4{
            text-align: center;
            margin-bottom: 0px;
        }
    </style>
</head>

<body>
    <h4>Rumah Makan Ayam Baltim</h4>
    <h4>Laporan Posisi Keuangan</h4>
    <h4>Untuk Periode Bulanan Yang Berakhir {{ $date.' '.$month.' '.$year }}</h4>
    <hr>
    <table class="table table-bordered">
        <tr>
            <td><b>ASET LANCAR</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Pendapatan Usaha</td>
            <td>Rp. {{ number_format($report->kas, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Piutang</td>
            <td>Rp. {{ number_format($report->piutang, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Persediaan</td>
            <td>Rp. {{ number_format($supply, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td><b>TOTAL ASET LANCAR</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($totalAsetLancar, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td><b>ASET TETAP</b></td>
            <td></td>
            <td></td>
        </tr>
        @if ($asetBangunan > 0)
        <tr>
            <td>Bangunan</td>
            <td>Rp. {{ number_format($asetBangunan, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        @endif
        @if (count($asset))
            @foreach ($asset as $item)
                @if ($item['year'] > 0)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Akumulasi Penyusutan {{ $item['name'] }}</td>
                        <td>-Rp. {{ number_format($item['beban'], 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                @elseif ($item['year'] == 0)
                    @if ($item['month'] >= 0)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Akumulasi Penyusutan {{ $item['name'] }}</td>
                            <td>-Rp. {{ number_format($item['beban'], 0, ',', '.') }}</td>
                            <td></td>
                        </tr>
                    @endif
                @endif
            @endforeach 
        @endif
        <tr>
            <td><b>TOTAL ASET TETAP</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($totalAsetTetap, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td style="color: red"><b>TOTAL ASET</b></td>
            <td></td>
            <td style="color: red"><b>Rp. {{ number_format($totalAset, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td rowspan="2"><b>LIABILITAS</b></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Utang Usaha</td>
            <td>Rp. {{ number_format($report->utang_usaha, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td>Utang Bank</td>
            <td>Rp. {{ number_format($report->utang_bank, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td><b>TOTAL LIABILITAS</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($totalLiabilitas, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td rowspan="2"><b>EKUITAS</b></td>
            <td rowspan="2"></td>
            <td rowspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Modal</td>
            <td>Rp. {{ number_format($modal, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td><b>TOTAL EKUITAS</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($modal, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td style="color: red"><b>TOTAL LIABILITAS & EKUITAS</b></td>
            <td></td>
            <td style="color: red"><b>Rp. {{ number_format($totalLnE, 0, ',', '.') }}</b></td>
        </tr>
    </table>
</body>

</html>
