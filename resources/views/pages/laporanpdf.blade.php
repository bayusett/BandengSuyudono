<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Laporan Produk Toko Bandeng Suyudono</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="/frontend/admin/dist/css/adminlte.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body onload="window.print();">
    <div class=" wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="container mt-2 ml-2">
                <table>
                    <tr>
                        <td><img src="images/salmon.png" style="width: 70px;"></td>
                        <td>Toko Bandeng Suyudono<br>
                            Telp: 082313920767<br>
                            alamat: Jl. Suyudono No.73, Barusari, Kec. Semarang Sel., Kota Semarang, Jawa Tengah 50245
                        </td>
                    </tr>
                </table>

            </div>
            <hr style="height: 1px; color: black; background-color: black;">
            <!-- /.row -->
            <div class="justify-content-center">
                <h1 class="text-center"><strong>Laporan Produk</strong></h1>
                <p class="text-left ml-2">Di Cetak : <?php echo date("Y-m-d") ?> </p>
                <p class="text-left ml-2">Periode Laporan: {{$from}} - {{$until}}</p>
            </div>
            <!-- Table row -->
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Nama Kategori</th>
                                <th>Harga</th>
                                <th>Quantitiy</th>
                                <th>Gambar Produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no =1;
                            @endphp
                            @foreach ($product as $item)
                            <tr>
                                <td>{{$no++}}</td>
                                <td>{{$item->created_at->format('d M Y')}}</td>
                                <td>{{$item->code}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->category->name}}</td>
                                <td>Rp{{ number_format($item->price,2,',','.') }}</td>
                                <td>{{$item->qty}}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->galleries()->get() as $gallery )
                                        <li>
                                            <img src="{{Storage::url($gallery->photos)}}" style="max-height:100px">
                                        </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>

</html>