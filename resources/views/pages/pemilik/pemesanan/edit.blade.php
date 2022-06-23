@extends('layouts.admin')
@section('title')
Halaman Utama Pemesanan
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Order Dashboard Edit</h1>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-dollar"></i> Detail Pembayaran
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No Pembayaran</td>
                                    <td>:</td>
                                    <td>{{$item->no_invoice}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembayaran</td>
                                    <td>:</td>
                                    <td>{{$item->created_at->format('d-m-Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Customer / Kode Customer</td>
                                    <td>:</td>
                                    <td>{{$item->customer->name}} / {{$item->customer->code}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{$item->customer->address}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>:</td>
                                    @if ($item->payment_status == 'CONFIRM')
                                    <td>
                                        <h4> <span class="badge badge-primary">Terkonfirmasi</span></h4>
                                    </td>
                                    @elseif ($item->payment_status == 'PENDING')
                                    <td>
                                        <h4> <span class="badge badge-warning">Pending</span></h4>
                                    </td>
                                    @else
                                    <td>
                                        <h4> <span class="badge badge-danger">Dibatalkan</span></h4>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-shopping-cart"></i> Order Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 25%;">
                                        Tanggal Transaksi
                                    </td>
                                    <td style="width: 1%;">:</td>
                                    <td>
                                        {{$oders->created_at->format('d-m-Y')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Pemesanan</td>
                                    <td>:</td>
                                    @if ($item->transaction_status == 'SUCCESS')
                                    <td>
                                        <h4> <span class="badge badge-primary">Terkirim</span></h4>
                                    </td>
                                    @elseif ($item->transaction_status == 'PROSES')
                                    <td>
                                        <h4> <span class="badge badge-secondary">Proses</span></h4>
                                    </td>
                                    @elseif ($item->transaction_status == 'SHIPPING')
                                    <td>
                                        <h4> <span class="badge badge-warning">Pengiriman</span></h4>
                                    </td>
                                    @else
                                    <td>
                                        <h4> <span class="badge badge-danger">Pending</span></h4>
                                    </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>Catatan</td>
                                    <td>:</td>
                                    <td>{{$oders->notes}}</td>
                                </tr>
                            </table>
                            <br>
                            @if ($item->payment_status != 'CONFIRM')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Pembayaran belum terkonfirmasi
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-box"></i> Detail Pemesanan Produk
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Kode Produk</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->TransactionDetails()->get() as $produk )
                                    <tr>
                                        <td>{{$produk->product->name}}</td>
                                        <td>{{$produk->product->code}}</td>
                                        <td>{{$produk->qty}}</td>
                                        <td>Rp {{number_format($produk->product->price)}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="3" class="text-center">Total harga</th>
                                        <td>Rp {{number_format($item->total_price)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection