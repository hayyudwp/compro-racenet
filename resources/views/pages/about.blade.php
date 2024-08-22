@extends('layouts.app')
@section('title', 'About - RACE NET')

@section('content')
<main>
    <div class="container">
        <div class="row my-5">
            <div class="col-md-5">
                @if(isset($content) && $content->image)
                    <img class="img-about" src="{{ asset('storage/content/'.$content->image) }}" alt="About Image">
                @else
                @endif
            </div>
            <div class="col-md-7 content-about position-relative">
                <h1 class="race-about absolute-about">RACE <span class="text-orange">NET</span></h1>
                <h1 class="race-about text-white">RACE NET</h1>
                @if(isset($content))
                    <h1 class="title-about">{{ $content->title }}</h1>
                    {!! $content->desc !!}
                @else
                    <h1 class="title-about">Default Title</h1>
                    <p>Default description for RACE NET. Please update the content.</p>
                @endif
            </div>
        </div>

        <div class="row mb-5">
            @if($abouts && $abouts->count() > 0)
                @foreach ($abouts as $a)
                    <div class="col-md-4 mb-3">
                        <div class="card card-about">
                            <div class="card-icon img-contain">
                                {!! $a->link_icon !!}
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
</main>
@endsection
