@extends('layouts.admin')
@section('title')
Halaman Utama Admin Produk
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Produk Dashboard Edit</h1>
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
                <div class="col-12">
                    <form action="{{route('products.update', $item->id)}}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="code">Kode Produk</label>
                                            <input type="text" class="form-control" id="code" aria-describedby="code" name="code" value="{{$item->code}}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">Product Name</label>
                                            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="{{$item->name}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" aria-describedby="price" name="price" value="{{$item->price}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="categories_id" class="form-control">
                                                <option value="{{$item->categories_id}}">Tidak diganti ({{$item->category->name}})</option>
                                                @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Quantity</label>
                                            <input type="number" class="form-control" id="qty" aria-describedby="qty" name="qty" value="{{$item->qty}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editor">Description</label>
                                            <textarea name="descrioption" id="editor" class="form-control">
                                        {!!$item->description !!}
                                </textarea>
                                        </div>
                                    </div>
                                    <div class="col text-right">
                                        <button type="submit" class="btn btn-success px-5">
                                            Update Product
                                        </button>
                                        <a href=" {{route('products.index')}}" class="btn btn-danger px-5">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($item->galleries as $gallery)
                                <div class="col-md-4">
                                    <div class="gallery-container">
                                        <img src="{{ Storage::url($gallery->photos ?? '') }}" alt="" class="w-100" />
                                        <a class="delete-gallery" href="{{route('product-gallery-delete',$gallery->id)}}" style=" display: block;position: absolute;top: -10px;right: 0;">
                                            <img src="/images/icon-delete.svg" alt="" />
                                        </a>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                            <div class="col mt-3">
                                <form action="{{route('product-gallery-upload')}}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <input type="hidden" value="{{ $item->id }}" name="products_id">
                                    <input type="file" name="photos" id="file" style="display: none;" onchange="form.submit()" />
                                    <button type="button" class="btn btn-secondary btn-block" onclick="thisFileUpload();">
                                        Add Photo
                                    </button>
                                </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/ckeditor.js"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
<script>
    function thisFileUpload() {
        document.getElementById("file").click();
    }
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush