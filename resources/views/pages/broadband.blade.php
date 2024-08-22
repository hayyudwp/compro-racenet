@extends('layouts.app')
@section('title', 'Broadband Internet - RACE NET')

@section('content')
<main>
   
    @foreach ($broadbands as $broadband)
    @php
        $text = $broadband->title;
        $words = explode(' ', $text);
        
        if (count($words) > 2) {
            $firstTwoWords = implode(' ', array_slice($words, 0, 2));
            $remainingWords = implode(' ', array_slice($words, 2));
            $formattedText = $firstTwoWords . '<br>' . $remainingWords;
        } else {
            $formattedText = $text;
        }
    @endphp
    @if ($loop->odd)
    <section style="background-color: #FFFFFF;">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6 text-center">
                    <img class="img-broadband-detail" src="{{ asset('storage/product/broadband/'.$broadband->image) }}" alt="About Image">
                </div>
                <div class="col-md-6 text-broadband-detail">
                    <div class="text-content text-broadband-mobile">
                        <h1 class="title-broadband-detail">{!! $formattedText !!}</h1>
                        <p class="desc-broadband-detail">{{$broadband->desc}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @elseif ($loop->even)
    <section style="background-color: #ECECEC;">
        <div class="container">
            <div class="row flex-reserve-mobile" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6 text-broadband-detail">
                    <div class="text-content text-right text-broadband-mobile">
                        <h1 class="title-broadband-detail">{!! $formattedText !!}</h1>
                        <p class="desc-broadband-detail">{{$broadband->desc}}</p>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img class="img-broadband-detail" src="{{ asset('storage/product/broadband/'.$broadband->image) }}" alt="About Image">
                </div>
            </div>
        </div>
    </section>
    @endif
    @endforeach
    
</main>
@endsection