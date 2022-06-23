   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
       <!-- Brand Logo -->
       <a href="{{route('admin-dashboard')}}" class="brand-link">
           <img src="/frontend/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: 0.8" />
           <span class="brand-text font-weight-light">Pemilik</span>
       </a>
       <!-- Sidebar -->
       <div class="sidebar">
           <!-- Sidebar user panel (optional) -->
           <div class="user-panel mt-3 pb-3 mb-3 d-flex">
               <div class="image">
                   @if (Auth::user()->photos == NULL)
                   <img src="{{auth()->user()->avatar_url}}" class="img-circle elevation-2 admin_picture" alt="User Image" />
                   @else
                   <img src="{{asset('users/images/' .auth()->user()->photos)}}" class="img-circle elevation-2 admin_picture" alt="User Image" />
                   @endif
               </div>
               <div class="info">
                   <a href="#" class="d-block">{{Auth::user()->name}}</a>
               </div>
           </div>

           <!-- Sidebar Menu -->
           <nav class="mt-2">
               <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                   <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                   <li class="nav-item">
                       <a href="{{route('pemilik-dashboard')}}" class="nav-link">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>Dashboard</p>
                       </a>
                   </li>
                   <li class="nav-header">PRODUK & KATEGORI</li>
                   <li class="nav-item">
                       <a href="{{route('pemilik-category')}}" class="nav-link {{(request()->is('pemilik/category*')) ? 'active' : ''}}">
                           <i class="nav-icon fas fa-columns"></i>
                           <p>Kategori</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{route('pemilik-products')}}" class="nav-link {{(request()->is('pemilik/products*')) ? 'active' : ''}}">
                           <i class="nav-icon fas fa-cart-plus"></i>
                           <p>
                               Produk
                           </p>
                       </a>
                   </li>

                   <li class="nav-header">LAINNYA</li>
                   <li class="nav-item">
                       <a href="{{route('pemilik-users')}}" class="nav-link {{(request()->is('pemilik/users*')) ? 'active' : ''}}">
                           <i class="nav-icon fas fa-user"></i>
                           <p>User</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{route('pemilik-customers')}}" class="nav-link {{(request()->is('pemilik/customers*')) ? 'active' : ''}}">
                           <i class="nav-icon fas fa-user"></i>
                           <p>Customer</p>
                       </a>
                   </li>
                   <li class="nav-header">TRASAKSI</li>
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-exchange-alt"></i>
                           <p>
                               Transaksi
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{route('pemilik-orders')}}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>pemesanan</p>
                               </a>
                           </li>
                       </ul>
                   </li>
                   <li class="nav-header">LAPORAN</li>
                   <li class="nav-item">
                       <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-file"></i>
                           <p>
                               Laporan
                               <i class="right fas fa-angle-left"></i>
                           </p>
                       </a>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{route('datalaporanpemilik')}}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>laporan Penjualan</p>
                               </a>
                           </li>
                       </ul>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{route('datapesananpemilik')}}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>Laporan Pemesanan</p>
                               </a>
                           </li>
                       </ul>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{route('dataproduk')}}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>Laporan Produk</p>
                               </a>
                           </li>
                       </ul>
                       <ul class="nav nav-treeview">
                           <li class="nav-item">
                               <a href="{{route('data.customer')}}" class="nav-link">
                                   <i class="far fa-circle nav-icon"></i>
                                   <p>Laporan Customer</p>
                               </a>
                           </li>
                       </ul>
                   </li>
                   <hr />
                   <li class="nav-item">
                       <a href="{{route('profile-pemilik.edit')}}" class="nav-link">
                           <i class="nav-icon fas fa-user"></i>
                           <p>Profile</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a href="{{route('password-pemilik.edits')}}" class="nav-link {{(request()->is('pemilik/password*')) ? 'active' : ''}}">
                           <i class="nav-icon fas fa-key"></i>
                           <p>Change Password</p>
                       </a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="{{ route('logout') }}" onclick=" event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class=" nav-icon fas fa-sign-out-alt"></i>
                           <p>Log Out</p>
                       </a>
                   </li>
                   <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                       @csrf
                   </form>
               </ul>
           </nav>
           <!-- /.sidebar-menu -->
       </div>
       <!-- /.sidebar -->

   </aside>