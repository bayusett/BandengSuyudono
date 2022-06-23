@extends('layouts.dashboard')
@section('title')
Halaman Utama Pesananku
@endsection
@section('content')
<!-- Page Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Pesananku</h2>
        </div>
        <br><br>
        <div class="dashboard-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-shopping-cart"></i> My Order
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Total Harga</th>
                                            <th>Status Pembayaran</th>
                                            <th>Tanggal</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order as $inv )
                                        <tr>
                                            <td>{{$inv->no_invoice}}</td>
                                            <td>Rp {{number_format($inv->total_price)}}</td>
                                            @if ($inv->payment_status == 'CONFIRM')
                                            <td>Terkonfirmasi</td>
                                            @elseif ($inv->payment_status == 'BATALKAN')
                                            <td>Dibatalkan</td>
                                            @else
                                            <td>Pending</td>
                                            @endif
                                            <td>{{$inv->created_at->format('d M Y')}}</td>
                                            @if ($inv->payment_status == 'BATALKAN')
                                            <td>
                                                <button type="button" class="btn btn-danger">Dibatalkan</button>
                                            </td>
                                            @else
                                            <td>
                                                <a href="{{route('user.order.detail',$inv->id)}}" class="btn btn-primary">Edit</a>
                                            </td>
                                            @endif
                                        </tr>

                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p>Tidak ada pesanan</p>
                                            </td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection