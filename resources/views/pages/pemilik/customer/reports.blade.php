@extends('layouts.admin')
@section('title')
Halaman Utama Pemilik Laporan Customer
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard Laporan Customer</h1>
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
                            <form action="{{route('generatecustomer')}}" method="POST">
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
                                    <a href="{{route('generateallcustomer')}}" target="_blank" class="btn btn-danger ml-2">Cetak semua</a>
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
                                    <input type="date" name="from_date" id="from_date" class="form-control from_date" value="{{date('Y-m-d')}}" />
                                </div>
                                <div class="form-group ml-2">
                                    <input type="date" name="to_date" id="to_date" class="form-control to_date" value="{{date('Y-m-d')}}" />
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
                                            <th>Tanggal Bergabung</th>
                                            <th>Kode Customer</th>
                                            <th>Nama Customer</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Provinsi</th>
                                            <th>Kabupaten/Kota</th>
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

    function datalaporan(from_date, to_date) {
        $('#crudTable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: {
                url: '{!! url()->current() !!}',
                data: {
                    from_date: from_date,
                    to_date: to_date
                }
            },
            columns: [{
                    data: 'created',
                    name: 'created'
                },
                {
                    data: 'code',
                    name: 'code'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'provinces',
                    name: 'provinces'
                },
                {
                    data: 'regencies',
                    name: 'regencies'
                },
            ]
        });
    }
    $(document).on('click', '#filter', function() {
        let from_date = $('.from_date').val()
        let to_date = $('.to_date').val()
        $('#crudTable').DataTable().destroy();
        datalaporan(from_date, to_date);
    })
    $('#refresh').click(function() {
        $('#from_date').val('');
        $('#to_date').val('');
        $('#crudTable').DataTable().destroy();
        datalaporan();
    });
</script>
@endpush