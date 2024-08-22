@extends('layouts.app')
@section('title', 'Coverage - RACE NET')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center my-5">
            <h1 class="text-center title-coverage">Cakupan Area</h1>
           
        </div>
        <div class="row reverse-content">
                <div class="col-md-8 maps-content">
                    <div id="mapContainer">
                        <iframe id="mapIframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d16327923.12635491!2d107.1863603228056!3d-2.40315796620598!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2c4c07d7496404b7%3A0xe37b4de71badf485!2sIndonesia!5e0!3m2!1sid!2sid!4v1721973349027!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <form id="coverage-form">
                        <div class="col-md-12"></div>
                        <label for="coverage" class="mb-3">Saat ini RACEnet sudah dapat melayani anda yang bertempat tinggal di :</label>
                        <select id="coverage" name="coverage" class="form-control mb-3">
                            <option value="" hidden disabled selected   >- Pilih Area -</option>
                            @foreach($coverages as $coverage)
                            <option value="{{ $coverage->code_map }}">{{ $coverage->area }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
    </div>
</main>
@endsection

@push('scripts')

@endpush