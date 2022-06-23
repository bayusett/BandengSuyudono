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
             <ul class="navbar-nav ml-auto">
                 <li class="nav-item active">
                     <a class="nav-link" href="{{route('home')}}">Beranda </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="{{route('categories')}}">Produk</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="#bantuan">Bantuan</a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>