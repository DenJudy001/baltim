<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekapitulasi Transaksi</title>
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
    <h4>Rekapitulasi Transaksi</h4>
    <h4>Rumah Makan Ayam Baltim</h4>
    @if ($startMonth == $endMonth && $startYear == $endYear)
        <h4>Per Tanggal {{ $startDay.'-'.$endDay.' '.$monthNameStart.' '.$startYear }}</h4>
    @else
        <h4>Per Tanggal {{ $startDay.' '.$monthNameStart.' '.$startYear.' - '.$endDay.' '.$monthNameEnd.' '.$endYear }}</h4>
    @endif
    <hr>
    <table class="table table-bordered">
        <tr>
            <td><b>KODE</b></td>
            <td><b>TANGGAL</b></td>
            <td><b>KETERANGAN</b></td>
            <td><b>PEMASUKAN</b></td>
            <td><b>PENGELUARAN</b></td>
        </tr>
        @foreach ($transactions as $item)
            @if (str_contains($item->purchase_number, 'PUR'))
                <tr>
                    <td>{{ $item->purchase_number }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->end_date)) }}</td>
                    <td>Transaksi Pembayaran {{ $item->purchase_name }}</td>
                    <td></td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @elseif (str_contains($item->purchase_number, 'SAL'))
                <tr>
                    <td>{{ $item->purchase_number }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->updated_at)) }}</td>
                    <td>Transaksi Pembayaran Gaji</td>
                    <td></td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @elseif (str_contains($item->purchase_number, 'TRX'))
                <tr>
                    <td>{{ $item->purchase_number }}</td>
                    <td>{{ date('d-m-Y', strtotime($item->end_date)) }}</td>
                    <td>Pemasukan Pendapatan Usaha</td>
                    <td>Rp. {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td colspan="3"><b>Total</b></td>
            <td><b>Rp. {{ number_format($total_income, 0, ',', '.') }}</b></td>
            <td><b>Rp. {{ number_format($total_expense, 0, ',', '.') }}</b></td>
        </tr>
    </table>
</body>

</html>
