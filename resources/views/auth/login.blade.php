@extends('layouts-admin.auth')
@section('title', 'RACE NET | Login')

@section('content')
<main>
  <div class="container">

    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="{{ route('home') }}" class="logo d-flex align-items-center w-auto text-center">
                <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 250px;">
              </a>
            </div><!-- End Logo -->

            <div class="mb-2">
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0">{{ session('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @elseif(session('failed'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p class="mb-0 text-center">{{ session('failed') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              @endif
            </div>

            <div class="card mb-3">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login</h5>
                </div>

                <form action="{{ route('authenticate') }}" method="post" class="row g-3 needs-validation" novalidate>
                  @csrf
                  <div class="col-12">
                    <label for="youremail" class="form-label">Username</label>
                    <div class="input-group has-validation">
                      <input type="text" name="name" class="form-control" required>
                      <div class="invalid-feedback">Please enter your username.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="yourPassword" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="yourPassword" required>
                    <div class="invalid-feedback">Please enter your password!</div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </div>
                </form>

              </div>
            </div>


          </div>
        </div>
      </div>
    </section>
  </div>
</main><!-- End #main -->
@endsection