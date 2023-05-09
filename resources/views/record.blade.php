<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/record.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">

</head>

<body>
  <form action="{{ route('records.store') }}" method="POST">
    @csrf

    @if(Session::has('error_message'))
    <div class="alert alert-danger">
      {{ Session::get('error_message') }}
    </div>
    @endif

      <div class="category">
        <button type="button" id="expenseBtn" onclick="selectCategory('expense')">Expense</button>
        <button type="button" id="incomeBtn" onclick="selectCategory('income')">Income</button>
      </div>

    <div class="forms">
      <label for="">amount:</label>
      <input type="text" placeholder="₽" name="peso">
    </div>

    <div class="forms">
      <label for="">category:</label>
      <select name="category" id="categorySelect">
        @if (old('q1') === 'expense')
          @foreach ($expense_categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        @elseif (old('q1') === 'income')
          @foreach ($income_categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        @endif
      </select>
      <input type="hidden" name="q1" id="q1">
    </div>

    <div class="forms">
      <label>memo:</label>
      <input type="text" placeholder="memo" name="memo">
    </div>

    <div class="forms">
      <label>date:</label>
      <input type="date" name="date">
    </div>

    <div class="subBtn">
      <button class="submit" type="submit">Submit</button>
    </div>

  </form>

  

  <footer>
    <a class="record" href="{{ route('records.create') }}">Record</a>
    <a href="{{ route('day.index') }}">Daily</a>
    <a href="{{ route('month.index') }}">Monthly</a>
    <a href="{{ route('my_page.show', Auth::user()->id) }}">My Page</a>
  </footer>

  <script>
    function selectCategory(value) {
      document.getElementById('q1').value = value;
      document.getElementById('categorySelect').innerHTML = ''; // カテゴリー選択欄をリセット
      if (value === 'expense') {
        // Expenseカテゴリーを表示
        @foreach ($expense_categories as $category)
          document.getElementById('categorySelect').innerHTML += '<option value="{{ $category->id }}">{{ $category->name }}</option>';
        @endforeach
      } else if (value === 'income') {
        // Incomeカテゴリーを表示
        @foreach ($income_categories as $category)
          document.getElementById('categorySelect').innerHTML += '<option value="{{ $category->id }}">{{ $category->name }}</option>';
        @endforeach
      }
    }
  </script>
</body>

</html>