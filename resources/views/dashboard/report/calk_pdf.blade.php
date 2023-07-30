<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Catatan Atas Laporan Keuangan</title>
    <style type="text/css">
        table {
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10pt;
            text-align: left;
        }

        /* table th,
        td {
            border-bottom: 1px solid #ddd;
        }

        table th {
            border-top: 1px solid #ddd;
            height: 40px;
        } */

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
    <h4>Catatan Atas Laporan Keuangan</h4>
    <h4>Rumah Makan Ayam Baltim</h4>
    <h4>Untuk Periode Bulanan Yang Berakhir {{ $date.' '.$month.' '.$year }}</h4>
    <hr>
    <table class="table table-borderless">
        <tr>
            <td><b>1</b></td>
            <td><b>UMUM</b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Rumah Makan Ayam Baltim merupakan usaha yang bergerak di 
                bidang jasa restoran atau rumah makan. Usaha ini berlokasi di Jalan Raya Serang No. 21, Cibadak, Kec. Cikupa, Kabupaten Tangerang, Banten 15710</td>
        </tr>
        <tr>
            <td><b>2</b></td>
            <td><b>IKHTISAR KEBIJAKAN AKUNTANSI PENTING</b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><b>a. Pernyataan Kepatuhan </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Laporan keuangan disusun berdasarkan Standar Akuntansi Keuangan Entitas Mikro, Kecil, 
                dan Menengah (SAK EMKM).</td>
        </tr>
        <tr>
            <td></td>
            <td><b>b. Dasar Penyusunan </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Dasar penyusunan laporan keuangan adalah biaya historis dan menggunakan asumsi 
                dasar akrual. Mata uang penyajian yang digunakan untuk penyusunan laporan keuangan adalah Rupiah.</td>
        </tr>
        <tr>
            <td></td>
            <td><b>c. Piutang Usaha </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Piutang usaha disajikan sebesar jumlah tagihan.
            </td>
        </tr>
        <tr>
            <td></td>
            <td><b>d. Persediaan </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Persediaan bahan baku meliputi ongkos pembelian dan ongkos angkut
                pembelian. Entitas menggunakan perhitungan persediaan rata-rata.
            </td>
        </tr>
        <tr>
            <td></td>
            <td><b>e. Aset Tetap </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Aset tetap ditulis sejumlah ongkos perolehannya. Aset tetap disusutkan
                mengunakan metode garis lurus.
            </td>
        </tr>
        <tr>
            <td></td>
            <td><b>f. Pengakuan Pendapatan dan Beban </b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"><q>Pendapatan diakui saat pelanggan membayar makanan yang dibeli.
                Beban diakui saat terjadi.
            </td>
        </tr>
        <tr>
            <td><b>3</b></td>
            <td><b>KAS</b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Kas</td>
            <td>Rp. {{ number_format($report->kas, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><b>4</b></td>
            <td><b>PIUTANG</b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Piutang</td>
            <td>Rp. {{ number_format($report->piutang, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><b>5</b></td>
            <td><b>PERSEDIAAN</b></td>
            <td></td>
        </tr>
        @if (count($supply) > 0)
            @foreach ($supply as $item)
                <tr>
                    <td></td>
                    <td>{{ $item->name }}</td>
                    <td>Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td></td>
            <td><b>TOTAL PERSEDIAAN</b></td>
            <td><b>Rp. {{ number_format($totalPersediaan, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td><b>6</b></td>
            <td><b>ASET TETAP</b></td>
            <td></td>
        </tr>
        @if ($asetBangunan > 0)
        <tr>
            <td></td>
            <td>Bangunan</td>
            <td>Rp. {{ number_format($asetBangunan, 0, ',', '.') }}</td>
        </tr>
        @endif
        @if (count($asset) > 0)
            @foreach ($asset as $item)
                @if ($item['year'] > 0)
                    <tr>
                        <td></td>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Akumulasi Penyusutan {{ $item['name'] }}</td>
                        <td>-Rp. {{ number_format($item['beban'], 0, ',', '.') }}</td>
                    </tr>
                @elseif ($item['year'] == 0)
                    @if ($item['month'] >= 0)
                        <tr>
                            <td></td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Akumulasi Penyusutan {{ $item['name'] }}</td>
                            <td>-Rp. {{ number_format($item['beban'], 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endif
            @endforeach 
        @endif
        <tr>
            <td></td>
            <td><b>TOTAL ASET TETAP</b></td>
            <td><b>Rp. {{ number_format($totalAsetTetap, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td><b>7</b></td>
            <td><b>PENDAPATAN PENJUALAN</b></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>Pendapatan</td>
            <td>Rp. {{ number_format($income, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><b>8</b></td>
            <td><b>BEBAN-BEBAN</b></td>
            <td></td>
        </tr>
        @if ($salary > 0)
            <tr>
                <td></td>
                <td>Beban Gaji</td>
                <td>Rp. {{ number_format($salary, 0, ',', '.') }}</td>
            </tr>
        @endif
        @foreach ($expense as $item)
            <tr>
                <td></td>
                <td>Beban {{ $item['name'] }}</td>
                <td>Rp. {{ number_format($item['total'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td><b>JUMLAH BEBAN</b></td>
            <td><b>Rp. {{ number_format($expenseTotal, 0, ',', '.') }}</b></td>
        </tr>
    </table>
</body>

</html>
