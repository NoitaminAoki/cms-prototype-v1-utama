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
    <table class="w-100">
        <thead>
            <tr>
                <th colspan="4" style="font-weight: bold">Paket: {{$jurnal['code']}}</th>
                <th style="font-weight: bold;text-align: right">{{$jurnal['tanggal']}}</th>
            </tr>
            <tr>
                <th style="width: 25px;" scope="col">#</th>
                <th style="font-weight: bold" scope="col">Nama</th>
                <th style="font-weight: bold" scope="col">Jumlah</th>
                <th style="font-weight: bold" scope="col">Harga Satuan</th>
                <th style="font-weight: bold" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list_items as $key => $item_jurnal)
            <tr>
                <td style="text-align: left">{{$key+1}}</td>
                <td>{{$item_jurnal->nama}}</td>
                <td style="text-align: left">{{$item_jurnal->jumlah}}</td>
                <td>{{$item_jurnal['harga_satuan']}}</td>
                <td>{{$item_jurnal['total_harga']}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>