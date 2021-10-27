<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Page 1</title>
</head>
<body>
    <table class="w-100 table table-bordered">
        <thead>
            <tr>
                <th colspan="2" style="font-weight: bold">Divisi</th>
                <th colspan="4" style="font-weight: bold">: {{$jurnal['divisi']}}</th>
                <th style="font-weight: bold;text-align: right">BULAN :</th>
                <th style="font-weight: bold;text-align: right">{{$jurnal['tanggal']}}</th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold">SUB DATA</th>
                <th colspan="4" style="font-weight: bold">: JURNAL HARIAN</th>
                <th style="font-weight: bold;text-align: right">CODE :</th>
                <th style="font-weight: bold;text-align: right">{{$jurnal['code']}}</th>
            </tr>
            <tr>
                <th rowspan="2" style="font-weight: bold;vertical-align: middle; text-align:center;" scope="col">No</th>
                <th rowspan="2" style="font-weight: bold;vertical-align: middle; text-align:center;" scope="col">Tgl</th>
                <th rowspan="2" style="font-weight: bold; vertical-align: middle; text-align: center;" scope="col">Uraian</th>
                <th colspan="2" style="font-weight: bold; text-align: center;" scope="col">KAS MASUK</th>
                <th colspan="2" style="font-weight: bold; text-align: center;" scope="col">KAS KELUAR</th>
                <th rowspan="2" style="font-weight: bold; vertical-align: middle; text-align: center;" scope="col">SALDO</th>
            </tr>
            <tr>
                <th style="font-weight: bold; text-align: center;" scope="col">Jumlah</th>
                <th style="font-weight: bold; text-align: center;" scope="col">Total</th>
                <th style="font-weight: bold; text-align: center;" scope="col">Jumlah</th>
                <th style="font-weight: bold; text-align: center;" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($previous_item)
            <tr>
                <td></td>
                <td></td>
                <td style="text-align: right"><i>Pemindahan Dana Jurnal Bulan {{$previous_item['month']}}</i></td>
                <td></td>
                <td style="text-align: right">{{$previous_item['total_in']}}</td>
                <td></td>
                <td style="text-align: right">{{$previous_item['total_out']}}</td>
                <td style="text-align: right">{{$previous_item['total_in'] - $previous_item['total_out']}}</td>
            </tr>
            @endif
            @forelse ($list_items as $key => $jurnal)
            <tr>
                <td style="text-align: center">{{$key+1}}</td>
                <td style="text-align: center">{{ date('d', strtotime($jurnal->tanggal)) }}</td>
                @if ($jurnal->type == 'masuk')
                @php
                $total['akumulasi_masuk'] += $jurnal->total;
                $total['saldo'] += $jurnal->total;
                @endphp
                <td style="font-weight: bold; text-align: right; "><i>{{$jurnal->description}}</i></td>
                <td style="text-align: right">{{$jurnal->total}}</td>
                <td style="text-align: right">{{$total['akumulasi_masuk']}}</td>
                <td></td>
                <td></td>
                @else
                @php
                $total['akumulasi_keluar'] += $jurnal->total;
                $total['saldo'] -= $jurnal->total;
                @endphp
                <td>{{$jurnal->description}}</td>
                <td></td>
                <td></td>
                <td style="text-align: right">{{$jurnal->total}}</td>
                <td style="text-align: right">{{$total['akumulasi_keluar']}}</td>
                @endif
                <td style="text-align: right">{{$total['saldo']}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>