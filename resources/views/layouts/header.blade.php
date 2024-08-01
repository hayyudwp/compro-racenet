 <!-- ======= Header ======= -->
 <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="{{ route('home') }}">
        <img src="{{ asset('img/logo.png') }}" alt="">
      </a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto  {{ (request()->segment(1) == '') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a></li>
          <li><a class="nav-link scrollto {{ (request()->segment(1) == 'about') ? 'active' : '' }}" href="{{ route('about') }}">Tentang Kami</a></li>
          <li><a class="nav-link scrollto {{ (request()->segment(1) == 'coverage') ? 'active' : '' }}" href="{{ route('coverage') }}">Cakupan Area</a></li>
          <li><a class="nav-link scrollto {{ (request()->segment(1) == 'contact') ? 'active' : '' }}" href="{{ route('contact') }}">Kontak</a></li>
          <li><a class="nav-link scrollto {{ (request()->segment(1) == 'help') ? 'active' : '' }}" href="{{ route('help') }}">Bantuan</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->