<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/success.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>

  <header>
    <h3>Cash Contorl</h3>
  </header>

  <main>

    <div class="content-box">

      <div>
        <h1>You are registered!</h1>
      </div>
      <div>
        <a href="{{ route('records.create') }}" class="button">Start recording</a>
      </div>

    </div>

  </main>
</body>
</html>