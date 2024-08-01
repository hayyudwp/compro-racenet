@extends('layouts.app')
@section('title', 'About RACE NET ')

@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-3 help-content">
                <ul id="help-flters" class="list-help justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter=".filter-help-panduan" class="filter-help-active">Panduan</li>
                    <li data-filter=".filter-help-faq">FAQ</li>
                    <li data-filter=".filter-help-pembayaran">Metode Pembayaran</li>
                    <li data-filter=".filter-help-troubleshoot">Troubleshoot</li>
                </ul>
            </div>
            <div class="col-md-9 border-left-bantuan content-help">
                <div class="help-container" data-aos="fade-up" data-aos-delay="200">
                    <div class="accordion help-item filter-help-panduan">
                        @foreach ($panduan as $d)
                        <div class="accordion-item">
                            <div class="accordion-item-header">
                                <span class="accordion-item-header-title">{{$d->question}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down accordion-item-header-icon">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                            <div class="accordion-item-description-wrapper">
                                <div class="accordion-item-description">
                                    <hr>
                                    {!!$d->answer!!}

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="accordion help-item filter-help-faq">
                        @foreach ($faq as $d)
                        <div class="accordion-item">
                            <div class="accordion-item-header">
                                <span class="accordion-item-header-title">{{$d->question}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down accordion-item-header-icon">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                            <div class="accordion-item-description-wrapper">
                                <div class="accordion-item-description">
                                    <hr>
                                    {!!$d->answer!!}
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="accordion help-item filter-help-pembayaran">
                        @foreach ($pembayaran as $d)
                        <div class="accordion-item">
                            <div class="accordion-item-header">
                                <span class="accordion-item-header-title">{{$d->question}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down accordion-item-header-icon">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                            <div class="accordion-item-description-wrapper">
                                <div class="accordion-item-description">
                                    <hr>
                                    {!!$d->answer!!}

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="accordion help-item filter-help-troubleshoot">
                        @foreach ($troubleshoot as $d)
                        <div class="accordion-item">
                            <div class="accordion-item-header">
                                <span class="accordion-item-header-title">{{$d->question}}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down accordion-item-header-icon">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                            <div class="accordion-item-description-wrapper">
                                <div class="accordion-item-description">
                                    <hr>
                                    {!!$d->answer!!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    
</script>
@endpush