@extends('layouts.app')
@section('title', 'RACE NET ')

@section('content')
<main>
    <div class="container">

        <div class="row mt-5" data-aos="fade-up" data-aos-delay="200">
            <div class="col-md-8">
                <h1 class="tagline-home">Nikmati <span class="tagline-blue">RACE NET</span> Internet Cepat dan Unlimited</h1>
                <p class="sub-tagline-home">Kami hadir memberikan layanan terbaik untuk kamu</p>
                <div class="d-flex my-5">
                    <div class="col-4 text-center">
                        <p class="top-home mb-0">100%</p>
                        <p class="bottom-home mb-0">Fiber Optic</p>
                    </div>
                    <div class="col-4 text-center mid-border">
                        <p class="top-home mb-0">1:1</p>
                        <p class="bottom-home mb-0">Kecepatan</p>
                    </div>
                    <div class="col-4 text-center">
                        <p class="top-home mb-0">100%</p>
                        <p class="bottom-home mb-0">Unlimited</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 right-dekstop">
                <img class="img-home" src="{{ asset('img/about_racenet.png') }}" alt="">
            </div>
        </div>

        <div class="row justify-content-center" >
            <div class="gradient"></div>
            <h2 class="text-center title-bandwith" data-aos="fade-up" data-aos-delay="200">Tentukan Bandwith Sesuai Kebetuhanmu</h2>
            <p class="text-center desk-bandwith" data-aos="fade-up" data-aos-delay="200">Sekarang saatnya menikmati kecepatan baru internet fiber ultra cepat dan unlimited dari RACE Net. Langganan Sekarang!</p>


            <ul id="portfolio-flters" class="list-bandwith d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                <li data-filter=".filter-home" class="filter-active">Home</li>
                <li data-filter=".filter-sekolah">Sekolah/Yayasan</li>
                <li data-filter=".filter-perusahaan">Perusahaan</li>
            </ul>
        </div>

        <div class="row portfolio-container portfolio-slider" data-aos="fade-up" data-aos-delay="200">
            @foreach ($pricelists as $pricelist)

            <div class="col-sm-6 col-md-4 col-lg-3 portfolio-item filter-{{$pricelist->category}}">
                <div class="portfolio-info card card-bandwith">
                    <p class="title-bw">{{$pricelist->title}}</p>
                    <h4 class="speed-bw">{{$pricelist->bandwith}}</h4>
                    <hr>
                    <div class="d-flex justify-content-center">
                        <p class="mb-0 idr">IDR </p>
                        <p class="mb-0 price">{{number_format($pricelist->price, 0, ",", ".")}}</p>
                        <p class="mb-0 month">/ Bulan</p>
                    </div>
                    <p class="ppn">Harga sudah termasuk ppn 11%</p>
                    <button class="btn btn-primary btn-regist mb-3">Langganan Sekarang</button>
                    <div class="desc-price">
                        {!! $pricelist->desc !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>


    </div>

    @foreach ($home_content as $data)
    <div class="row side-image">
        <img src="{{ asset("storage/home/" . $data->value_file) }}" alt="">
    </div>
    @endforeach
</main>
@endsection

@push('scripts')

@endpush