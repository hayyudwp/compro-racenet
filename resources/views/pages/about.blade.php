@extends('layouts.app')
@section('title', 'About RACE NET ')

@section('content')
<main>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-5">
                <img class="img-about" src="{{ asset('storage/content').'/'.$content->image }}" alt="">
            </div>
            <div class="col-md-7 content-about position-relative">
                <h1 class="race-about absolute-about">RACE <span class="text-orange">NET</span></h1>
                <h1 class="race-about text-white">RACE NET</h1>
                <h1 class="title-about">{{$content->title}}</h1>
                {!!$content->desc!!}

            </div>
        </div>

        <div class="row mb-5">
            @foreach ($abouts as $a)
            <div class="col-md-4 mb-3">
                <div class="card card-about">
                    <div class="card card-icon img-contain">
                    {!!$a->link_icon!!}
                    </div>
                    <h3 class="title-list-about">{{$a->title}}</h3>
                    {!!$a->desc!!}
                </div>
            </div>
            @endforeach
           
        </div>
    </div>
</main>
@endsection