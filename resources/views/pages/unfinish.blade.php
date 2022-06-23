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
                    <img src="/images/cancel.png" alt="" class="mb-4 w-50" />
                    <h2>
                        Oops!
                    </h2>
                    <p>
                        Pembayaran kamu belum selesai
                    </p>
                    <div>
                        <a href="{{route('dashboard')}}" class="btn btn-success w-50 mt-4">
                            My Dashboard
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