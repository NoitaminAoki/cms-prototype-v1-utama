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
                <th colspan="5" style="font-weight: bold">Paket: {{$jurnal['code']}}</th>
                <th style="font-weight: bold;text-align: right">{{$jurnal['tanggal']}}</th>
            </tr>
            <tr>
                <th style="width: 25px;" scope="col">#</th>
                <th style="font-weight: bold" scope="col">Deskripsi</th>
                <th style="font-weight: bold" scope="col">Satuan</th>
                <th style="font-weight: bold" scope="col">Jumlah</th>
                <th style="font-weight: bold;" scope="col">Harga Satuan</th>
                <th style="font-weight: bold; text-align: center;" scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($list_items as $key => $kwitansi)
            @foreach ($kwitansi['realisasi_danas'] as $re_key => $realisasi_dana)
            @if ($realisasi_dana['pengajuan'])
            <tr>
                <td style="text-align: left;">{{$re_key+1}}</td>
                <td>{{$realisasi_dana['format_code']}}</td>
                <td colspan="4">{{$realisasi_dana['pengajuan']['item']['nama']}}</td>
            </tr>
            @foreach ($realisasi_dana['pengajuan']['material_pengajuans'] as $mat_key => $material_pengajuan)
            <tr>
                <td style="text-align: left;">{{$re_key+1}}.{{$mat_key+1}}</td>
                <td>{{$material_pengajuan['material']['nama_material']}}</td>
                <td>{{$material_pengajuan['material']['ms_satuan']['satuan']}}</td>
                <td style="text-align: left;">{{$material_pengajuan['jumlah']}}</td>
                <td>{{$material_pengajuan['harga_satuan']}}</td>
                <td>{{$material_pengajuan['total_harga']}}</td>
            </tr>
            @endforeach
            @endif
            @endforeach
            @empty
            <tr>
                <td colspan="6" class="text-center text-muted">Empty</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>