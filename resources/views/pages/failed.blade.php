@extends('layouts.success')

@section('title')
Store Success Page
@endsection

@section('content')
<div class="page-content page-success">
    <div class="section-success" data-aos="zoom-in">
        <div class="container">
            <div class="row align-items-center row-login justify-content-center">
                <div class="col-lg-6 text-center">
                    <h2>
                        Oops!
                    </h2>
                    <p>
                        Pembayaran Kamu Gagal
                        <br>
                        silahkan hubungi kami jika masalah ini terjadi
                    </p>
                    <div>
                        <a href=" https://wa.me/6282313920767?text=Hai+kak+saya+pembayaran+saya+gagal+mohon+bantuannya+kak" class="btn btn-success w-50 mt-4">
                            Whatsapp
                        </a>
                        <a href="{{route('home')}}" class="btn btn-signup w-50 mt-2">
                            Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection