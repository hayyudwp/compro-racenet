  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <img src="{{ asset('img/logo.png') }}" alt="" class="logo-footer">
            <p>
              RACEnet mengedepankan layanan internet yang cepat dan handal dengan teknologi Fiber Optic yang semua layanan dari kami bebas quota atau unlimited.
            </p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>QUICK LINK</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Beranda</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Tentang Kami</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Cakupan Area</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Kontak</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Bantuan</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              <li class="p-0"><strong>Head Office :</strong></li>
              <li class="pt-0">Jl. Kubis 3 Pondok Cabe Ilir Tangerang Selatan</li>
              <li class="p-0"><strong>Sukabumi Branch :</strong></li>
              <li class="pt-0">Perum Mutiara Lido Sukabumi Jawa Barat</li>
              <li class="p-0"><strong>Bogor Branch 1 :</strong></li>
              <li class="pt-0">Jl. Kayu Manis Tanah Sereal Bogor Jawa Barat</li>
              <li class="p-0"><strong>Bogor Branch 2 :</strong></li>
              <li class="pt-0">Kierana Indah Residence 2 Blok D4 No. 27 Parung Bogor</li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <ul>
              <li class="p-0"><strong>Support Team :</strong></li>
              <table class="mb-3">
                <tr>
                  <td>Email</td>
                  <td>:</td>
                  <td>support@race.net.id</td>
                </tr>
                <tr>
                  <td>Whatsapp</td>
                  <td>:</td>
                  <td>0822-1078-0120</td>
                </tr>
              </table>
              <li class="p-0"><strong>Sales Team :</strong></li>
                <table class="mb-3">
                  <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>sales@race.net.id</td>
                  </tr>
                  <tr>
                    <td>Whatsapp</td>
                    <td>:</td>
                    <td>0812-7447-7725</td>
                  </tr>
                </table>
                
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