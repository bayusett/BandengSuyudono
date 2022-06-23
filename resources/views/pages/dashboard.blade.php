@extends('layouts.dashboard')
@section('title')
Halaman Utama
@endsection
@section('content')
<!-- Page Content -->
<div class="section-content section-dashboard-home" data-aos="fade-up">
    <div class="container-fluid">
        <div class="dashboard-heading">
            <h2 class="dashboard-title">Dashboard</h2>
            <p class="dashboard-subtitle">
                Look what you have made today!
            </p>
        </div>
        <div class="dashboard-content">
            <div class="row">
                <h1>Selamat Datang {{Auth::guard('customer')->user()->name}}</h1>
            </div>
        </div>
    </div>
</div>
@endsection