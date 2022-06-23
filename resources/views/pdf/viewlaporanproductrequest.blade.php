<!DOCTYPE html>

<head>
    <title>Laporan Produk</title>
    <style>
        #table1 th {
            border: 1px solid black;
            padding: 7px;
        }

        #table1 td {
            border: 1px solid black;
            padding: 7px;
        }

        #table1 {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td><img src="images/salmon.png" style="width: 70px;"></td>
            <td>Toko Bandeng Suyudono<br>
                Telp: 082313920767<br>
                alamat: Jl. Suyudono No.73, Barusari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50245
            </td>
        </tr>
    </table>
    <hr style="height: 1px; color: black; background-color: black;">
    <h2 style="text-align: center;"><strong>Laporan Produk</strong></h2>

    <h4 style="text-align: left; margin-top: 4px;">Di cetak : <?php echo date("Y-m-d") ?></h4>
    <h4 style="text-align: left; margin-top:2px;">Laporan Produk Periode: {{$from}} - {{$until}}</h4>
    <table id="table1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Nama Kategori</th>
            <th>Harga</th>
            <th>Quantity</th>
            <th>Gambar Produk</th>
        </tr>
        <?php $no = 1; ?>
        @php
        $no =1;
        @endphp
        @foreach ($produk as $data)
        <tr>
            <td>{{ $no++}}</td>
            <td>{{$data->created_at->format('d M Y') }}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->category->name }}</td>
            <td>Rp {{number_format($data->price,2,',','.')}}</td>
            <td>{{ $data->qty }}</td>
            <td>
                <ul>
                    @foreach ($data->galleries()->get() as $gallery )
                    <li><img src="{{ public_path($gallery->photos) }}"></li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
</body>

</html>