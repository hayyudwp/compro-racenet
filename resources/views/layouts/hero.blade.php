<div class="d-flex align-items-center">

  <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner">
      @foreach($headers as $index => $header)
      <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
        <div class="d-block w-100 carousel-image" style="background-image: linear-gradient(to top, rgb(50, 152, 178, 1), rgb(121, 222, 248, 0)75%), url('{{ asset('storage/header/' . $header->image) }}')">
        <div class="text-hero overlay">
        
        <div class="col-lg-8 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1 class="title-hero">{{ $header->title }}</h1>
          <h2 class="desc-hero">{{ $header->desc }}</h2>
        </div>
        </div>

        </div>


      </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

@push('scripts')
<script>
</script>
@endpush