{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header_left">
            <a href="{{ url('/top') }}">
                <h3>Cash Control</h3>
            </a>
        </div>
    </header>
    <main>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="title">
                <h3>Register</h3>
            </div><hr>
            
            <div class="content-box">
                <div class="content">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="content">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="content">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="content">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
            </div>

            <div class="button">
                <div class="col-md-6 offset-md-4">
                    <button style="height:30px;" type="submit" class="register-button">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
        </form>
   
    </main>
    <footer></footer>
</body>
</html>
{{-- @endsection --}}
