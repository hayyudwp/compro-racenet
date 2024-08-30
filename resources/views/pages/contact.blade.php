@extends('layouts.app')
@section('title', 'Contact - RACE NET')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center my-5">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            <div class="col-md-7">
                <div class="card card-contact">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input-name">Nama</label>
                                    <input type="name" class="form-control" name="name" id="input-name" placeholder="name@example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="input-email">Email</label>
                                    <input type="email" class="form-control" name="email" id="input-email" placeholder="name@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="exampleFormControlTextarea1">Pesan</label>
                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary btn-contact mb-3 text-center">Submit</button>
                    </form>


                    <div class="d-flex">
                        <div class="col-md-7">
                            <ul class="list-office">
                                @foreach ($branch as $b)
                                <li> 
                                    <strong>{{$b->title}} :</strong> 
                                    <br>
                                    {{$b->desc}}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <ul class="list-office">
                                <li> <strong>Contact Center </strong></li>
                                @foreach ($contact_footer as $c)
                                <li> 
                                    <strong>{{$c->title}} :</strong> 
                                    <br>
                                    <div class="page_contact">
                                        {!! $c->desc !!}
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="img-contact">
                    <div class="abso-content">
                        <img src="{{ asset("img/img-contact.jpg") }}" alt="">
                        <p class="text-img-about">Anda mencari informasi lebih lanjut atau ingin mencoba salah satu rencana berbayar Asana kami? Kirim informasi Anda dan
                            seorang perwakilan Asana akan menghubungi Anda secepat mungkin. Punya pertanyaan sederhana?
                            <a href="{{ route('help') }}" class="link-faq">Lihat Halaman FAQ</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection