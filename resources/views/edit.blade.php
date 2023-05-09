<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="{{ asset('css/edit.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>
  <div class="back">
    <a href="{{ url()->previous() }}">Back</a>
  </div>
  <form action="{{ route('records.update', $record->id) }}" method="POST">
    @csrf
    @method('put')
    <div class="forms">
      <label for="">amount:</label>
      <input type="text" class="form-control" value="{{ $record->peso }}" name="peso">
    </div>
    <div class="forms">
      <label for="">category:</label>
      <select name="category">
        @if ( $option == 1)
          @foreach ($expense_categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $record->expense_category_id ? 'selected' : '' }}>{{ $category->name }} </option>
          @endforeach
        @elseif ($option == 2)
          @foreach ($income_categories as $category)
            <option value="{{ $category->id }}" {{ $category->id == $record->income_category_id ? 'selected' : '' }}>{{ $category->name }}</option>
          @endforeach
        @endif
      </select>
    </div class="forms">
    <div class="forms">
      <label for="">memo:</label>
      <input type="text" value="{{ $record->memo }}" name="memo">
    </div>

    <div class="forms">
      <label for="">date:</label>
      <input type="date" value="{{ substr($record->date, 0, 10) }}" name="date">
    </div>

    <input type="hidden" value="{{ $option }}" name="option">

  
    <button class="button" type="submit">Edit</button>
  </form>

  <form action="{{ route('records.destroy', ['option' => $option, 'id' => $record->id ]) }}" method="POST">
    @csrf
    @method('DELETE')
    <input class="button" type="submit" value="Delete" onclick="return confirm('Do you really want to delete this?');">
  </form>

</body>
</html>