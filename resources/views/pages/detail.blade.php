@extends('layouts.app')

@section('title')
Detail Produk {{$product->name}}
@endsection

@section('content')
<!-- Page Content -->
<div class="page-content page-details">
    <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('home')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <a href="{{route('categories-detail',$product->category->slug)}}"> {{$product->category->name}}</a>
                            </li>
                            <li class="breadcrumb-item active">
                                {{$product->name}}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="store-gallery mb-3" id="gallery">
        <div class="container">
            <div class="row">
                <div class="col-lg-8" data-aos="zoom-in">
                    <transition name="slide-fade" mode="out-in">
                        <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-100 main-image" alt="" />
                    </transition>
                </div>
                <div class="col-lg-2">
                    <div class="row">
                        <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos" :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                            <a href="#" @click="changeActive(index)">
                                <img :src="photo.url" class="w-100 thumbnail-image" :class="{ active: index == activePhoto }" alt="" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="store-details-container product_data" data-aos="fade-up">
        <section class="store-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h1>{{ $product->name }}</h1>
                        @if ($product->qty > 0)
                        <label>Stok : {{$product->qty}} tersedia</label>
                        @else
                        <label class="badge bg-danger text-white">Out of Stock</label>
                        @endif
                        <div class="price harga">Rp {{ number_format($product->price) }}</div>
                    </div>
                    <div class="col-lg-2" data-aos="zoom-in">
                        @auth('customer')
                        @if ($product->qty > 0)
                        <button type="button" class="btn btn-success px-4 text-white btn-block mb-3 addToCart">
                            Add to Cart
                        </button>
                        @else
                        <button type="button" class="btn btn-success px-4 text-white btn-block mb-3 addToCart" disabled>
                            Add to Cart
                        </button>
                        @endif

                        @else
                        <a href="{{ route('customer.login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                            Add to Cart
                        </a>
                        @endauth
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input type="hidden" value="{{$product->id}}" class="product_id"></input>
                        <label>Jumlah</label>
                        <div class="input-group text-center mb-3">
                            <button class="input-group-text decrement_btn">-</button>
                            <input type="number" class="form-control text-center qty-input" name="qty" value="1"></input>
                            <button class="input-group-text increment_btn">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="store-description">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-8">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
@push('addon-script')
	<script src="/script/custom_details.js"></script>
    <script src="/vendor/vue/vue.js"></script>
    <script>
      var gallery = new Vue({
        el: "#gallery",
        mounted() {
          AOS.init();
        },
        data: {
          activePhoto: 0,
          photos: [
            @foreach ($product->galleries as $gallery)
            {
              id: {{ $gallery->id }},
              url: "{{ Storage::url($gallery->photos) }}",
            },
            @endforeach
          ],
        },
        methods: {
          changeActive(id) {
            this.activePhoto = id;
          },
        },
      });
    </script>

@endpush