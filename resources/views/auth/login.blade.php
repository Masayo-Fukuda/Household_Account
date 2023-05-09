<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
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
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="title">
                <h3>Login</h3>
            </div><hr>

            <div class="content-box">

                <div class="content">
                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

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
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>    
                      
            <div class="check-content">
                <input class="check-box" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> 

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>                        
            

            <div class="button">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>

        </form>
        
    </main>
</body>
</html>
