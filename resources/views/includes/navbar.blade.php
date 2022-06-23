    <!-- Navigation -->
    <nav class="
        navbar navbar-expand-lg navbar-light navbar-store
        fixed-top
        navbar-fixed-top
      " data-aos="fade-down">
        <div class="container">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="/images/salmon.png" alt="" style="width: 60px; height: 60px;" />
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <div class="col-md-5 d-none d-md-block ml-3">
                    <form class="search-wrap" action="/">
                        <div class="input-group w-100">
                            <input type="text" class="form-control search-form" style="width: 55%; border: 1px solid #ffffff" name="key" placeholder="Mau Beli apa hari ini ?" value="{{request('key')}}" />
                            <div class="input-group-append">
                                <button type="submit" class="btn search-button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{(request()->is('/')) ? 'active' : ''}}">
                        <a class="nav-link" href="{{route('home')}}">Beranda </a>
                    </li>
                    <li class="nav-item {{(request()->is('categories')) ? 'active' : ''}}">
                        <a class="nav-link" href="{{route('categories')}}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#bantuan">Bantuan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('faq')}}" target="_blank">FAQ</a>
                    </li>
                    @guest('customer')
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customer.register')}}">Daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-success nav-link px-4 text-white" href="{{route('customer.login')}}">Masuk</a>
                    </li>
                    @endguest
                </ul>
                @auth('customer')
                <!-- Desktop Menu -->
                <ul class="navbar-nav d-none d-lg-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link mt-2 d-flex" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::guard('customer')->user()->photos == NULL)
                            <img src="{{Auth::guard('customer')->user()->avatar_url}}" alt="" class="rounded-circle mr-2 profile-picture" />
                            @else
                            <img src="{{asset('customers/images/' .Auth::guard('customer')->user()->photos)}}" alt="" class="rounded-circle mr-2 profile-picture" />
                            @endif
                            Hi, {{Auth::guard('customer')->user()->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('dashboard')}}">Dashboard</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('detail-carts') }}" class="nav-link d-inline-block mt-3">

                            <img src="/images/icon-cart-empty.svg" alt="" />
                            <span class="badge badge-spill bg-success cart-count text-white">0</span>

                        </a>
                    </li>
                </ul>

                <!-- Mobile Menu -->
                <ul class="navbar-nav d-block d-lg-none">
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Hi, {{Auth::guard('customer')->user()->name}} </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('detail-carts') }}" class="nav-link d-inline-block mt-3">

                            <img src="/images/icon-cart-empty.svg" alt="" />
                            <span class="badge badge-spill bg-success cart-count text-white">0</span>

                        </a>
                    </li>
                </ul>
                @endauth
            </div>
        </div>
    </nav>