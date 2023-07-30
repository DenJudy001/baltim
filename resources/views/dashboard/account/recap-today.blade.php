@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb no-bg">
            <li class="breadcrumb-item"><a href="javascript:history.back()">Kembali</a></li>
        </ol>
    </nav>
</div>
<div class="card">
    <div class="card-header bg-white">
        <div class="row">
            <div class="col"><h4 class="font-weight-bold">{{ $title }}</h4></div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table ">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="5%">No.</th>
                        <th scope="col" width="20%">Kode Transaksi</th>
                        <th scope="col" width="15%">Waktu</th>
                        <th scope="col" width="30%">Total</th>
                    </tr>
                </thead>
                @if ($total>0)
                    <tbody class="table-group-divider">
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }} </td>
                                <td>
                                    @if (str_contains($type, 'expense'))
                                        @if (str_contains($transaction->purchase_number, 'PUR'))
                                        <a href="/purchase/{{ $transaction->purchase_number }}?today=1">{{ $transaction->purchase_number }}</i></a>
                                        @elseif (str_contains($transaction->purchase_number, 'SAL'))
                                        <a href="/salary/{{ $transaction->purchase_number }}?today=1">{{ $transaction->purchase_number }}</i></a>
                                        @endif
                                    @elseif (str_contains($type, 'income'))
                                        <a href="/pos/{{ $transaction->pos_number }}?today=1">{{ $transaction->pos_number }}</i></a>
                                    @endif
                                </td>
                                <td>{{ date('H:i', strtotime($transaction->updated_at)) }}</td>
                                <td>Rp. {{ number_format($transaction->total, 0, ',', '.')}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="font-weight-bold">TOTAL</td>
                            <td class="font-weight-bold">Rp. {{ number_format($total, 0, ',', '.')}}</td>
                        </tr>
                    </tfoot>
                @else
                    <tbody class="table-group-divider">
                        <tr>
                            <td colspan="4" class="text-center">Data Transaksi Tidak Tersedia</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection