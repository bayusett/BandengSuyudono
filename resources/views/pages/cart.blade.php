@extends('layouts.app')

@section('title')
Store Cart Page
@endsection

@section('content')
<!-- Page Content -->
<div class="page-content page-cart">
    <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Cart
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section class="store-cart">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-12 table-responsive">
                    <table class="table table-borderless table-cart">
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Produk</td>
                                <td>Harga</td>
                                <td class="text-center">Jumlah</td>
                                <td>Menu</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0 @endphp
                            @forelse ( $carts as $cart)

                            <tr class="product_data">
                                <td>
                                    @if($cart->product->galleries->count())
                                    <img src="{{ Storage::url($cart->product->galleries->first()->photos) }}" alt="" class="cart-image" />
                                    @else
                                    @endif
                                </td>
                                <td>
                                    <div class="product-title">{{ $cart->product->name }}</div>
                                </td>
                                <td>
                                    <div class="product-title">Rp {{ number_format($cart->product->price) }}</div>
                                </td>
                                <td>
                                    <div class="justify-content-center d-flex mt-3">
                                        <input type="hidden" value="{{$cart->product->id}}" class="product_id">
                                        @if ($cart->product->qty >= $cart->qty)

                                        <button class="input-group-text changeQuantity decrement_btn">-</button>
                                        <input type="text" class="form-control text-center qty-input" name="qty" value="{{$cart->qty}}" style="width: 20%;"></input>
                                        <button class="input-group-text changeQuantity increment_btn">+</button>
                                        @php $totalPrice += $cart->product->price * $cart->qty @endphp
                                        @else
                                        <h6>Out Of Stok</h6>
                                        @endif
                                    </div>

                                </td>
                                <td>
                                    <form action="{{ route('cart-delete', $cart->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-remove-cart" type="submit">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <td colspan="5">
                                <p class="text-center mt-4">Keranjang Kosong ( tidak Ada Produk )</p>
                            </td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($totalPrice != 0)
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="col-12">
                    <hr />
                </div>
                <div class="col-12">
                    <h2 class="mb-4">Shipping Details</h2>
                </div>
            </div>
            <form action="{{ route('checkout') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                <div class="row mb-2" data-aos="fade-up" data-aos-delay="200" id="locations">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address_one">Alamat</label>
                            <br>
                            <textarea name="address" id="" cols="40"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="phone_number">Nomor Handphone</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="provinces_id">Provinsi</label>
                            <select class="form-control" id="provinsi" name="provinces_id">
                                <option hidden>Choose Provinsi</option>
                                @foreach ($provinces as $provinsi)
                                <option value="{{$provinsi->id}}">{{$provinsi->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kabupaten" class="form-label">Kabupaten</label>
                            <select class="form-control" id="kabupaten" name="regencies_id"></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catatan</label>
                            <br>
                            <input type="radio" id="html" name="notes" value="diantar">
                            <label for="html">Diantar</label><br>
                            <input type="radio" id="css" name="notes" value="diambil">
                            <label for="css">Diambil</label><br>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="150">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-12">
                        <h2 class="mb-1">Informasi Pembayaran</h2>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-4 col-md-2">
                        <div class="product-title text-success">Rp {{ number_format($totalPrice ?? 0) }}</div>
                        <div class="product-subtitle">Total</div>
                    </div>
                    <div class="col-8 col-md-3">
                        <button type="submit" class="btn btn-success mt-4 px-4 btn-block">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </section>
</div>
@endsection

@push('addon-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $(".increment_btn").click(function(e) {
            e.preventDefault();
            var inc_cart = $(this).closest('.product_data').find('.qty-input').val();
            var value = parseInt(inc_cart, 10);
            value = isNaN(value) ? 0 : value;

            if (value < 10) {
                value++;
                $(this).closest('.product_data').find('.qty-input').val(value);
            }
        });
        $(".decrement_btn").click(function(e) {
            e.preventDefault();
            var dec_cart = $(this).closest('.product_data').find('.qty-input').val();
            var value = parseInt(dec_cart, 10);
            value = isNaN(value) ? 0 : value;

            if (value > 1) {
                value--;
                $(this).closest('.product_data').find('.qty-input').val(value);
            }
        });

        $('.changeQuantity').click(function(e) {
            e.preventDefault();
            var product_id = $(this).closest('.product_data').find('.product_id').val();

            var qty = $(this).closest('.product_data').find('.qty-input').val();
            data = {
                'product_id': product_id,
                'product_qty': qty,
            }
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "POST",
                url: "update-cart",
                data: data,
                success: function(response) {
                    window.location.reload();
                }
            });
        })
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
                    url: "{{route('getkabupaten')}}",
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