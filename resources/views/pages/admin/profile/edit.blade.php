@extends('layouts.admin')
@section('title')
Halaman Utama Admin Profile
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Change Your Profile</h1>
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
                <div class="col-md-3">
                    <!-- Profile Images -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (Auth::user()->photos == NULL)
                                <img class="profile-user-img img-fluid img-circle admin_picture" src="{{auth()->user()->avatar_url}}">
                                @else
                                <img class="profile-user-img img-fluid img-circle admin_picture" src="{{asset('users/images/' .auth()->user()->photos)}}">
                                @endif
                            </div>
                            <h3 class="profile-username text-center admin_name">{{Auth::user()->name}}</h3>
                            <p class="text-muted text-center">{{Auth::user()->roles}}</p>

                            <input type="file" name="photos" id="admin_images" style="opacity: 0;height:1px;display:none">
                            <a href="javascript:void(0)" class="btn btn-primary btn-block" id="change_picture_btn"><b>Change picture</b></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            @if (session()->has('message'))
                            <div class="alert alert-success">{{session()->get('message')}}</div>
                            @endif
                            <form id="locations" action="{{route('profile-admin.edit')}}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" name="name" class="form-control" value="{{old('name',Auth::user()->name)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" value="{{old('email',Auth::user()->email)}}" name="email" class="form-control">

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nomor Telephone</label>
                                            <input type="text" name="phone_number" value="{{old('phone_number',Auth::user()->phone_number)}}" class="form-control">
                                            @error("phone_number")
                                            <div class="text-red-500 mt-2 text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea name="address" id="" cols="25" rows="5">{{old('address',Auth::user()->address)}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select class="form-control" id="provinsi" name="provinces_id">
                                                <option hidden>Choose Provinsi</option>
                                                @foreach ($provinces as $provinsi)
                                                <option value="{{$provinsi->id}}" {{$provinsi->id ==$user->provinces_id ? "selected":''}}>{{$provinsi->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                                            <select class="form-control" id="kabupaten" name="regencies_id">
                                                @if (!auth()->user()->regencies_id == NULL)
                                                <option value="{{$kabupaten->id}}">{{$kabupaten->name}}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-success px-5">Save</button>
                                        <a href="{{route('admin-dashboard')}}" class="btn btn-danger px-5">Kembali</a>
                                    </div>
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
@push('addon-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('script/ijaboCropTool.min.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '#change_picture_btn', function() {
        $('#admin_images').click();
    });
    $('#admin_images').ijaboCropTool({
        preview: '.admin_picture',
        setRatio: 1,
        allowedExtensions: ['jpg', 'jpeg', 'png'],
        buttonsText: ['CROP', 'QUIT'],
        buttonsColor: ['#30bf7d', '#ee5155', -15],
        processUrl: '{{ route("adminUpdatePicture") }}',
        // withCSRF:['_token','{{ csrf_token() }}'],
        onSuccess: function(message, element, status) {
            alert(message);
        },
        onError: function(message, element, status) {
            alert(message);
        }
    });
</script>
<script>
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('#provinsi').on('change', function() {
                let idprovinsi = $('#provinsi').val();
                // console.log(idprovinsi);

                $.ajax({
                    type: 'POST',
                    url: "{{route('getkabupatens')}}",
                    data: {
                        idprovinsi: idprovinsi
                    },
                    cache: false,
                    success: function(msg) {
                        $('#kabupaten').html(msg);
                    },
                    error: function(data) {
                        console.log('error:', data);
                    },
                })
            })
        })
    })
</script>
@endpush