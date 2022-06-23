<!DOCTYPE html>

<head>
    <title>Laporan Pemesanan</title>
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
    <h2 style="text-align: center;"><strong>Laporan Pemesanan</strong></h2>

    <h4 style="text-align: left; margin-top: 4px;">Di cetak : <?php echo date("Y-m-d") ?></h4>
    <table id="table1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nomor Transaksi</th>
            <th>Nama Customer</th>
            <th>Produk yang di order</th>
            <th>Total Pembelian</th>
            <th>Status Pembayaran</th>
        </tr>
        <?php $no = 1; ?>
        @foreach ($penjualan as $data)
        <tr>
            <td>{{ $no++}}</td>
            <td>{{$data->created_at->format('d M Y') }}</td>
            <td>{{ $data->no_invoice }}</td>
            <td>{{ $data->customer->name }}</td>
            <td>
                <ul>
                    @foreach ($data->TransactionDetails()->get() as $produk )
                    <li>{{$produk->product->name}}</li>
                    @endforeach
                </ul>
            </td>
            <td>Rp {{ number_format($data->total_price,2,',','.') }}</td>
            <td>{{$data->payment_status}}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>