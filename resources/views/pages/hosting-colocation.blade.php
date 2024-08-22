@extends('layouts.app')
@section('title', 'Hosting & Collocation - RACE NET')

@section('content')
<main>
    <section>
        <div class="container">
            <div class="row flex-reserve-mobile" data-aos="fade-up" data-aos-delay="200">

                @foreach ($hostings as $a)
                <div class="col-md-7 content-about position-relative">
                    <h1 class="title-dedicated">{{ $a->title }}</h1>
                    <p class="desc-dedicated">{{ $a->desc }} </p>
                    <a href="" class="move-up btn btn-primary btn-dedicated">Hubungi Kami</a>
                </div>
                <div class="col-md-5 text-center-mobile">
                    <img class="img-about width-80-mobile" src="{{ asset('storage/product/hosting/'.$a->image) }}" alt="About Image">
                </div>
            </div>
            @endforeach

        </div>
    </section>
    <section class="background-gradient-blue">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div data-aos="fade-up" data-aos-delay="200">
                    <p class="top-title-hosting-detail">Fitur dan Keunggulan</p>
                    <h1 class="title-hosting-detail">Cloud Hosting RACE NET</h1>
                </div>
                @if($hosting_details && $hosting_details->count() > 0)
                @foreach ($hosting_details as $a)
                <div class="col-md-5 mb-5 text-center-mobile" data-aos="fade-up" data-aos-delay="200">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="card card-icon-hosting img-contain">
                                {!! $a->link !!}
                            </div>
                        </div>
                        <div class="col-md-10 text-white mt-10-mobile">
                            <h3 class="title-list-about text-white">{{ $a->title }}</h3>
                            {!! $a->desc !!}
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                </div>
                @endif
            </div>

        </div>
    </section>

    <section>
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="200">

                @foreach ($colocations as $a)
                <div class="col-md-5 text-center-mobile">
                    <img class="img-about width-80-mobile" src="{{ asset('storage/product/colocation/'.$a->image) }}" alt="About Image">
                </div>
                <div class="col-md-7 content-about position-relative">
                    <h1 class="title-dedicated">{{ $a->title }}</h1>
                    <p class="desc-dedicated">{{ $a->desc }} </p>
                    <a href="" class="move-up btn btn-primary btn-dedicated">Hubungi Kami</a>
                </div>

            </div>
            @endforeach
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="title-colocation-detail"> Fitur Colocation Server</h1>
                    <p class="bottom-title-colocation-detail">Dapatkan berbagai layanan yang akan membantu performa server Anda.</p>
                </div>
                @if($colocation_details && $colocation_details->count() > 0)
                @foreach ($colocation_details as $a)
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-colocation ">
                        <div class="card-icon-dedicated img-contain">
                            {!! $a->link !!}
                        </div>
                        <h3 class="title-list-colocation">{{ $a->title }}</h3>
                        <p class="desc-list-colocation">{{$a->desc}}</p>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                </div>
                @endif
            </div>

        </div>
    </section>
</main>


@endsection