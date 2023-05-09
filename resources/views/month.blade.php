<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/month.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

  <div class="date">
    <button id="prev-month-btn" type="button"><i class="fa-solid fa-lg fa-circle-chevron-left"></i></button>
    <span id="prev-month" data-date="{{ $currentMonth }}">{{ $currentMonth }}</span>
    <button id="next-month-btn" type="button" ><i class="fa-solid fa-lg fa-circle-chevron-right"></i></button>
  </div>

  <script>

    let optionBtn = ''

    $('#prev-month-btn').click(function() {

      $.ajax({
        url: '/prev-month',
        type: 'GET',
        dataType: 'json',
        data: {
          param1: $('#prev-month').data('date')
        },
        success: function(response) {
          $('#prev-month').html(response);

          $('#prev-month').data('date', response);

          getData(optionBtn)
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    });

    $('#next-month-btn').click(function() {
      $.ajax({
        url: '/next-month',
        type: 'GET',
        dataType: 'json',
        data: {
          param1: $('#prev-month').data('date')
        },
        success: function(response) {
          $('#prev-month').html(response);

          $('#prev-month').data('date', response);
          var option = $('input[name="option"]:checked').val();
          getData(optionBtn)
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    });
  </script>

  <div class="category">
    <button type="button" class="main-button" data-option="1">Expense</button>
    <button type="button" class="main-button" data-option="2">Income</button>
  </div>

  <div>
    <table style="margin-bottom: 2rem;">
      <thead>
        <tr>
          <th> Monthly Total:</th>
          <th id="total-result"></th>
        </tr>
      </thead>
      <tbody id="result">
      </tbody>
    </table>
  </div>

  <script>
    $('button[data-option]').click(function() {
      $('button[data-option]').removeClass('active-button')

      var option = $(this).data('option');
      if($('button[data-option]').hasClass('active-button')){
        $(this).removeClass('active-button')
      } else {
        $(this).addClass('active-button')
      }

      optionBtn = option
      getData(option)
    });

    $('.btn').click(function() {
        var option = $(this).data('option');

        optionBtn = option
        getData(option);
      });

    function getData(option){
      $.ajax({
        url: '/get-month',
        data: {
          option,
          param1: $('#prev-month').data('date')
        },
        success: function(totalByCategory) {
          let html = ''
          let total = 0
            $.each(totalByCategory, function (index, category){ 
              html += `<tr>
                  <td>${category?.category_name}</td>    
                  <td>¥${category?.total_sum}</td>    
                </tr>`
              total += Number(category.total_sum)
            })
            $('#result').html(html)
            $('#total-result').text(`¥ ${total}`);
        }
      })
    }
  </script>

<footer>
  <a href="{{ route('records.create') }}">Record</a>
  <a href="{{ route('day.index') }}">Daily</a>
  <a class="monthly" href="{{ route('month.index') }}">Monthly</a>
  <a href="{{ route('my_page.show', Auth::user()->id) }}">My Page</a>
</footer>
</body>
</html>