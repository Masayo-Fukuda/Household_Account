<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>
  <main>

    <div class="box">

      <div class="title">
        <h3>Information</h3>
      </div><hr>

      <div class="content">

        <h5>User Name:</h5>
        <p>{{ Auth::user()->name }}</p>
      
        <h5>Email:</h5>
        <p>{{ Auth::user()->email }}</p>
      </div>

      <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button style="height:30px;" type="submit" class="register-button">
          {{ __('Logout') }}
        </button>
      </form>
    
    </div>

  </main>
  <footer>
    <a href="{{ route('records.create') }}">Record</a>
    <a href="{{ route('day.index') }}">Daily</a>
    <a href="{{ route('month.index') }}">Monthly</a>
    <a class="myPage" href="{{ route('my_page.show', Auth::user()->id) }}">My Page</a>
  </footer>
</body>
</html>