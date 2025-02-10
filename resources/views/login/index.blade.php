@extends('layouts.main')

@section('container')
    <br><br><br>
    <div class="container mt-8">
        <center>
            <h1 class="sitename" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">MyInventory</h1>
        </center>
        <div class="row justify-content-center">
            <div class="col-lg-4 mt-4">


                {{-- Kotak untuk Form Login --}}
                <div class="card shadow-lg">
                    <div class="card-body">
                        {{-- Logo --}}
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/img/diskominfo.svg') }}" alt="Logo Diskominfo" class="img-fluid"
                                style="max-width: 150px;">
                        </div>

                        {{-- Alert for Registration Success --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Alert for Login Error --}}
                        @if (session('loginError'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('loginError') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Login Form --}}
                        <main class="form-signin">
                            <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
                            <form action="/login" method="post">
                                @csrf
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="name@example.com" autofocus required name="email"
                                        value="{{ old('email') }}">
                                    <label for="email">Email address</label>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> <br>

                                <div class="form-floating">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" placeholder="Password" name="password" required>
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div><br>

                                <button class="btn btn-primary w-100 py-2 mb-2" type="submit">Login</button>
                            </form>
                        </main>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
