@extends('layouts.admin')
@section('title')
Halaman Utama Admin Users
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
                                    <td>{{$order->payment->no_invoice}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>:</td>
                                    @if ($order->payment->transaction_status == 'CONFIRM')
                                    <td>
                                        <h4> <span class="badge badge-primary">{{$order->payment->transaction_status}}</span></h4>
                                    </td>
                                    @elseif ($order->payment->transaction_status == 'PENDING')
                                    <td>
                                        <h4> <span class="badge badge-warning">{{$order->payment->transaction_status}}</span></h4>
                                    </td>
                                    @else
                                    <td>
                                        <h4> <span class="badge badge-danger">{{$order->payment->transaction_status}}</span></h4>
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
                                <i class="fas fa-dollar"></i> Payment Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 25%;">
                                        No Transaksi
                                    </td>
                                    <td style="width: 1%;">:</td>
                                    <td>
                                        {{$order->code}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Pengiriman</td>
                                    <td>:</td>
                                    @if ($order->shipping_status == 'SUCCESS')
                                    <td>
                                        <h4> <span class="badge badge-primary">{{$order->shipping_status}}</span></h4>
                                    </td>
                                    @elseif ($order->shipping_status == 'SHIPPING')
                                    <td>
                                        <h4> <span class="badge badge-warning">{{$order->shipping_status}}</span></h4>
                                    </td>
                                    @else
                                    <td>
                                        <h4> <span class="badge badge-info">{{$order->shipping_status}}</span></h4>
                                    </td>
                                    @endif
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-products"></i> Product Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>@mdo</td>
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