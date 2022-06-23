@extends('layouts.admin')
@section('title')
Halaman Utama Admin Laporan Penjualan
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cetak Laporan Penjualan</h1>
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
                            <form action="{{route('generatepenjualan')}}" method="POST">
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
                                    <a href="{{route('generateallreports')}}" target="_blank" class="btn btn-danger ml-2">Cetak semua</a>
                                </div>
                            </form>
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