  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            @foreach ($footer_desc as $f)
            <img src="{{ asset('storage/footer/logo/'.$f->image) }}" alt="" class="logo-footer">
            <p>
              {{$f->desc}}
            </p>
            @endforeach

          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>QUICK LINK</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('home') }}">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('broadband') }}">Produk</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">Tentang Kami</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('coverage') }}">Cakupan Area</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('contact') }}">Kontak</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="{{ route('help') }}">Bantuan</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              @foreach ($branch as $b)
              <li class="p-0"><strong>{{$b->title}} :</strong></li>
              <li class="pt-0">{!! $b->desc !!}</li>
              @endforeach
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              @foreach ($contact_footer as $c)
              <div class="contact_footer mb-3">
                <li class="p-0"><strong>{{$c->title}} :</strong></li>
                {!! $c->desc !!}
              </div>
              @endforeach                
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container text-center footer-bottom clearfix">
      <div class="media">
        <div class="social-links mt-3">
          @foreach ($sosmed as $data)
            <a href="{{$data->link}}" class="icon-footer">{!! $data->code_icon !!}</a>
          @endforeach
        </div>
      </div>
      <div class="color-black mt-3">
         Copyright &copy; 2024 <strong><span>PT. REZEKI ASA CEMERLANG.</span></strong>
      </div>
      
    </div>
  </footer><!-- End Footer -->