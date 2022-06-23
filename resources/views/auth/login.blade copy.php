@extends('layouts.auth')

@section('title')
Bandeng Suyudono - Halaman Masuk
@endsection

@section('content')

<!-- Page Content -->
<div class="page-content page-auth">
    <div class="section-store-auth" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center row-login">
                <div class="col-lg-6 text-center">
                    <img src="/images/login-placeholder.png" alt="" class="w-50 mb-4 mb-lg-none" />
                </div>
                <div class="col-lg-5">
                    <form method="POST" action="{{ route('login') }}" class="mt-3">
                        @csrf
                        <div class="form-group">
                            <label>Email address</label>
                            <input id="email" type="email" class="form-control w-75 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input id="password" type="password" class="form-control w-75 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button class="btn btn-success btn-block w-75 mt-4" type="submit">
                            Masuk
                        </button>
                        <a class="btn btn-signup w-75 mt-2" href="{{url('register')}}">
                            Daftar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection