<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('img/icon-logo-150.png') }}" type="image/png">
  <link rel="icon" href="{{ asset('img/icon-logo-150.png') }}" sizes="32x32">
  <link rel="icon" href="{{ asset('img/icon-logo-300.png') }}" sizes="192x192">
  <link rel="apple-touch-icon" href="{{ asset('img/icon-logo-300.png') }}" sizes="192x192">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  @stack('styles')
  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  
  <!-- Font Awesome (jika diperlukan) -->
  <!-- Template Main CSS File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/style-mobile.css') }}" rel="stylesheet">
  
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick-theme.css"/>

</head>

<body>
  @include('layouts.header')
  @include('layouts.hero')
  @yield('content')
  @include('layouts.footer')

  <!-- <div id="preloader"></div>
  <a href="#" class="whatsapp-button d-flex align-items-center justify-content-center">
    <i class="bi bi-whatsapp"></i>
  </a> -->

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
  <!-- Template Main JS File -->

  <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>


  <script>
    $(document).ready(function() {

      $('#coverage').change(function() {
        var mapLink = $(this).val();
        if (mapLink) {
          $('#mapIframe').attr('src', mapLink);
        } else {
          $('#mapIframe').attr('src', '');
        }
      });

      
    });
  </script>
  @stack('script')
</body>

</html>