@extends('layouts.app')
@section('title', 'Manage Service Solution - RACE NET')

@section('content')
<main>
<section>
        <div class="container">
            <div class="row my-5" data-aos="fade-up" data-aos-delay="200">

                @foreach ($manage_services as $a)
                <div class="col-md-7 content-about position-relative">
                    <h1 class="title-dedicated">{{ $a->title }}</h1>
                    <p class="desc-dedicated">{{ $a->desc }} </p>
                    <a href="" class="move-up btn btn-primary btn-dedicated">Hubungi Kami</a>
                </div>
                <div class="col-md-5 text-center-mobile">
                    <img class="img-about width-80-mobile" src="{{ asset('storage/product/manage-service/'.$a->image) }}" alt="About Image">
                </div>
            </div>
            @endforeach
        </div>
    </section>


    <section class="background-gradient-blue">
        <div class="container">

            <div class="row justify-content-center">
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="title-dedicated-detail title-bandwith mt-0">Layanan Manage Service Solution
                        RACE NET</h1>
                </div>
                @if($manage_service_details && $manage_service_details->count() > 0)
                @foreach ($manage_service_details as $a)
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