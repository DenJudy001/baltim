<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Laba Rugi</title>
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
    <h4>Laporan Laba Rugi</h4>
    <h4>Untuk Periode Bulanan Yang Berakhir {{ $date.' '.$month.' '.$year }}</h4>
    <hr>
    <table class="table table-bordered">
        <tr>
            <td><b>PENDAPATAN</b></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Pendapatan Usaha</td>
            <td>Rp. {{ number_format($income, 0, ',', '.') }}</td>
            <td></td>
        </tr>
        <tr>
            <td><b>JUMLAH PENDAPATAN</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($income, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td><b>BEBAN-BEBAN</b></td>
            <td></td>
            <td></td>
        </tr>
        @if ($salary > 0)
            <tr>
                <td>Beban Gaji</td>
                <td>Rp. {{ number_format($salary, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        @endif
        @foreach ($expense as $item)
            <tr>
                <td>Beban {{ $item['name'] }}</td>
                <td>Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
                <td></td>
            </tr>
        @endforeach
        <tr>
            <td><b>JUMLAH BEBAN</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($expenseTotal, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td><b>LABA (RUGI) USAHA</b></td>
            <td></td>
            <td><b>Rp. {{ number_format($labaRugi, 0, ',', '.') }}</b></td>
        </tr>
    </table>
</body>

</html>
