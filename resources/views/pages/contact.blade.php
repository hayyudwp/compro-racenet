@extends('layouts.app')
@section('title', 'Contact - RACE NET')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center my-5">
           <div class="col-md-7">
                <div class="card card-contact">
                    <form action="{{ route('contact.store') }}">
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
                        <button class="btn btn-primary btn-contact mb-3">Submit</button>
                    </form>


                    <div class="d-flex">
                        <div class="col-md-7">
                            <ul class="list-office">
                                <li> <strong>Head Office :</strong> <br>Jl. Kubis 3 Pondok Cabe Ilir Tangerang Selatan</li>
                                <li> <strong>Sukabumi Branch :</strong> <br>Perum Mutiara Lido Sukabumi Jawa Barat</li>
                                <li> <strong>Bogor Branch 1 :</strong> <br>Jl. Kayu Manis Tanah Sereal Bogor Jawa Barat</li>
                                <li> <strong>Bogor Branch 2 :</strong> <br>Kierana Residance 2 Blok D4 No. 27, Parung, Bogor</li>
                            </ul>
                        </div>
                        <div class="col-md-5">
                            <ul class="list-office">
                                <li> <strong>Contact Center </strong></li>
                                <li> <strong>Support Team :</strong> <br>Email          : support@race.net.id <br> Whatsapp : 0822-1078-0120</li>
                                <li> <strong>Sales Team :</strong> <br>Email          : sales@race.net.id <br> Whatsapp : 0812-7447-7725</li>
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