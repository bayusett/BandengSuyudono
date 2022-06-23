@extends('layouts.dashboard')
@section('title')
Halaman Utama detail pesanan
@endsection
@section('content')
<!-- Page Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Detail Order {{$order->code}}</h2>
        </div>
        <br><br>
        <div class="dashboard-content">
            @if ($item->payment_status != 'CONFIRM')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Pembayaran belum terkonfirmasi, silahkan hubungi nomor admin yang tertara pada website
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
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
                                    <td>Nama Customer</td>
                                    <td>:</td>
                                    <td>{{$item->customer->name}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{$item->customer->address}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>:</td>
                                    <td>
                                        {{$item->payment_status}}
                                    </td>
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
                            <form action="{{route('user.order.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <table class="table table-bordered">
                                    <tr>
                                        <td style="width: 25%;">
                                            Tanggal Transaksi
                                        </td>
                                        <td style="width: 1%;">:</td>
                                        <td>
                                            {{$order->created_at->format('d-m-Y')}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status Pemesanan</td>
                                        <td>:</td>
                                        <td>
                                            @if ($item->transaction_status == 'PROCCESS')
                                            <p>Pesanan sedang diproses</p>
                                            @else
                                            {{$item->transaction_status}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td> Catatan</td>
                                        <td>:</td>
                                        <td>{{$order->notes}}</td>
                                    </tr>
                                </table>
                                <br>
                                @if ($item->payment_status == 'CONFIRM')
                                <div class="row justify-content-beetwen">
                                    <div class="col text-left">
                                        @if ($item->transaction_status != 'SUCCESS')
                                        <button type="submit" class="btn btn-success px-5" onclick="return confirm('Apakah Kamu yakin?')">Terkirim</button>
                                        @endif
                                        <a href="{{route('users.order')}}" class="btn btn-danger px-5">Kembali</a>
                                    </div>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-12 col-12 mt-4">
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
                                        <th colspan="3" class="text-center">Total Harga</th>
                                        <td>Rp {{number_format($item->total_price)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection