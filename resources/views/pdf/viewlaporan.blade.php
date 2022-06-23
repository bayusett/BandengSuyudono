<!DOCTYPE html>

<head>
    <title>Laporan Penjualan</title>
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
    <h2 style="text-align: center;"><strong>Laporan Penjualan</strong></h2>

    <h4 style="text-align: left; margin-top: 4px;">Di cetak : <?php echo date("Y-m-d") ?></h4>
    <table id="table1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Transaksi</th>
            <th>Nama Produk</th>
            <th>Jumlah Terjual</th>
            <th>Harga Produk</th>
            <th>Total Harga</th>
        </tr>
        <?php $no = 1; ?>
        @php
        $total = 0;
        $count =0;
        @endphp
        @foreach ($penjualan as $data)
        @php
        $count = $data->qty * $data->product->price;
        $total += $count;
        @endphp
        <tr>
            <td>{{ $no++}}</td>
            <td>{{$data->created_at->format('d M Y') }}</td>
            <td>{{ $data->code }}</td>
            <td>{{ $data->product->name }}</td>
            <td>{{ $data->qty }}</td>
            <td>Rp{{number_format($data->product->price,2,',','.') }}</td>
            <td>Rp {{ number_format($count,2,',','.') }}</td>
        </tr>
        @endforeach
        <tr>
            <th colspan="6">Total Pendapatan</th>
            <th>Rp {{number_format($total,2,',','.')}}</th>
        </tr>
    </table>
</body>

</html>