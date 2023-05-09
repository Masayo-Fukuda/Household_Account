<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/top.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>
  <header>
    @if (Route::has('login'))
            @auth
              <div class="header_left">
                <a href="{{ url('/top') }}">Cash Control</a>
              </div>
              <div class="header_right">
                <a href="{{ route('records.create') }}">Start recording</a>
              </div>
            @else
              <div class="header_left">
                <a href="{{ url('/top') }}">Cash Control</a>
              </div>
              <div class="header_right">
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
              </div>
            @endauth
      @endif
  </header>

  <main>

    <h1 class="catchphrase">take Control of your money and your life</h1>

    <video autoplay muted loop id="bgvideo">
      <source src="https://player.vimeo.com/external/465226688.sd.mp4?s=373c659401e01212eca6cd617d678fb246f35ac8&profile_id=164" type="video/mp4">
    </video>
  </main>
</body>
</html>