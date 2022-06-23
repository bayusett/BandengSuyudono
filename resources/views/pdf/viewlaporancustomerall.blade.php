<!DOCTYPE html>

<head>
    <title>Laporan Customer</title>
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
    <h2 style="text-align: center;"><strong>Laporan Customer</strong></h2>

    <h4 style="text-align: left; margin-top: 4px;">Di cetak : <?php echo date("Y-m-d") ?></h4>
    <table id="table1">
        <tr>
            <th>No</th>
            <th>Tanggal Bergabung</th>
            <th>Kode Customer</th>
            <th>Nama Customer</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Provinsi</th>
            <th>Kabupaten/Kota</th>
        </tr>
        @php
        $no =1;
        @endphp
        @foreach ($customer as $data)
        <tr>
            <td>{{ $no++}}</td>
            <td>{{$data->created_at->format('d M Y') }}</td>
            <td>{{$data->code}}</td>
            <td>{{ $data->name }}</td>
            <td>{{ $data->email}}</td>
            <td>{{$data->address ? $data->address :'-'}}</td>
            <td>{{$data->provinces_id ? $data->province->name : '-' }}</td>
            <td>{{$data->regencies_id ? $data->regency->name : '-' }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>