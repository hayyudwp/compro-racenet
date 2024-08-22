@extends('layouts.app')
@section('title', 'IT Solution - RACE NET')

@section('content')
<main>
<section>
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="200">

                @foreach ($it_solutions as $a)
                <div class="col-md-5 text-center-mobile">
                    <img class="img-about width-80-mobile" src="{{ asset('storage/product/it-solution/'.$a->image) }}" alt="About Image">
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
                    <h1 class="title-colocation-detail"> Layanan IT Solution</h1>
                    <p class="bottom-title-colocation-detail">Dapatkan berbagai layanan yang akan membantu performa Anda.</p>
                </div>
                @if($it_solution_details && $it_solution_details->count() > 0)
                @foreach ($it_solution_details as $a)
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
