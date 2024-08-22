@extends('layouts.app')
@section('title', 'Dedicated Internet - RACE NET')

@section('content')
<main>
    <section>
        <div class="container">
            <div class="row flex-reserve-mobile" data-aos="fade-up" data-aos-delay="200">

                @foreach ($dedicateds as $a)
                <div class="col-md-7 content-about position-relative">
                    <h1 class="title-dedicated">{{ $a->title }}</h1>
                    <p class="desc-dedicated">{{ $a->desc }} </p>
                    <p>*S&K Berlaku</p>
                    <a href="" class="move-up btn btn-primary btn-dedicated text-center-mobile">Hubungi Kami</a>
                </div>
                <div class="col-md-5 text-center-mobile">
                    <img class="img-about width-80-mobile" src="{{ asset('storage/product/dedicated/'.$a->image) }}" alt="About Image">
                </div>
            </div>
            @endforeach
        </div>
    </section>


    <section class="background-gradient-blue">
        <div class="container">

            <div class="row justify-content-center">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="title-dedicated-detail title-bandwith mt-0">Mengapa Harus Menggunakan Layanan Dedicated Internet
                        RACE NET?</h1>
                </div>
                @if($dedicated_details && $dedicated_details->count() > 0)
                @foreach ($dedicated_details as $a)
                <div class="col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-dedicated">
                        <div class="card-icon-dedicated img-contain">
                            {!! $a->link !!}
                        </div>
                        <h3 class="title-list-about">{{ $a->title }}</h3>
                        {!! $a->desc !!}
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