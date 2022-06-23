@extends('layouts.admin')
@section('title')
Halaman Utama Admin Laporan Pemesanan
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Laporan Pemesanan</h1>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('generatepesanan')}}" method="POST">
                                @csrf
                                <div class="input-group mb-3">
                                    <label for="from">Tanggal Awal</label>
                                    <input type="date" name="from" id="from_date" class="form-control ml-2">
                                </div>
                                <div class="input-group mb-3">
                                    <label for="until">Tanggal Akhir</label>
                                    <input type="date" name="until" id="to_date" class="form-control ml-2">
                                </div>
                                <div class="input-group mb-3 justify-content-center">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i></button>
                                    <a href="{{route('generateallpesanan')}}" target="_blank" class="btn btn-danger ml-2">Cetak semua</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="d-flex justify-content-center mt-2">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label>Choose a Payment:</label>
                                    <select id="pemesanan" class="form-control pemesanan ml-2" name="pemesanan">
                                        <option value="PENDING">PENDING</option>
                                        <option value="CONFIRM">CONFIRM</option>
                                    </select>
                                </div>
                                <button id="filter" class="btn btn-success ml-2">Filter</button>
                                <button type="button" name="refresh" id="refresh" class="btn btn-danger ml-2"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>No Transaksi</th>
                                            <th>Nama Customer</th>
                                            <th>Produk yang diorder</th>
                                            <th>Total Pembelian</th>
                                            <th>Status Pembayaran</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
@push('addon-script')
<script>
    $(document).ready(function() {
        // $('.from_date').datepicker({
        //     format: 'yyyy-dd-mm',
        //     uiLibrary: 'bootstrap4',

        // });
        // $('.to_date').datepicker({
        //     format: 'yyyy-dd-mm',
        //     uiLibrary: 'bootstrap4',
        // });
        datalaporan()
    });

    function datalaporan(pemesanan) {
        $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
                data: {
                    pemesanan: pemesanan
                }
            },
            columns: [{
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'payments',
                    name: 'payments'
                },
                {
                    data: 'customers',
                    name: 'customers'
                },

                {
                    data: 'products',
                    name: 'products'
                },
                {
                    data: 'price',
                    name: 'Price',
                    render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')
                },
                {
                    data: 'status_pembayaran',
                    name: 'status_pembayaran'
                },
            ]
        });
    }
    $(document).on('click', '#filter', function() {
        let pemesanan = $('.pemesanan').val()
        $('#crudTable').DataTable().destroy();
        datalaporan(pemesanan);
    });
    $('#refresh').click(function() {
        $('#pemesanan').val('');
        $('#crudTable').DataTable().destroy();
        datalaporan();
    });
</script>
@endpush