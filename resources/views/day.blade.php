<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/day.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300" rel="stylesheet">
</head>
<body>
  <div class="date">
    <button id="prev-week-btn" type="button"><i class="fa-solid fa-lg fa-circle-chevron-left"></i></button>
    <span id="prev-week-mon" data-date="{{ $currentWeekMonday }}">{{ $currentWeekMonday }}</span>
    <span>~</span>
    <span id="prev-week-sun" data-date="{{ $currentWeekSunday }}">{{ $currentWeekSunday }}</span>
    <button id="next-week-btn" type="button" ><i class="fa-solid fa-lg fa-circle-chevron-right"></i></button>
  </div>


  <script>

    let optionBtn = ''
    
    $('#prev-week-btn').click(function() {
     

      $.ajax({
        url: '/prev-week',
        type: 'GET',
        dataType: 'json',
        data: {
          param1: $('#prev-week-mon').data('date'),
          param2: $('#prev-week-mon').data('date')
        },
        success: function(response) {
          $('#prev-week-mon').html(response.prevWeekStart);
          $('#prev-week-sun').html(response.prevWeekEnd);

          $('#prev-week-mon').data('date', response.prevWeekStart);
          $('#prev-week-sun').data('date', response.prevWeekEnd);
          
          getData(optionBtn)
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      }); 
    });

    $('#next-week-btn').click(function() {
      $.ajax({
        url: '/next-week',
        type: 'GET',
        dataType: 'json',
        data: {
          param1: $('#prev-week-mon').data('date'),
          param2: $('#prev-week-mon').data('date')
        },
        success: function(response) {
          $('#prev-week-mon').html(response.nextWeekStart);
          $('#prev-week-sun').html(response.nextWeekEnd);

          $('#prev-week-mon').data('date', response.nextWeekStart);
          $('#prev-week-sun').data('date', response.nextWeekEnd);
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
  
  <div id="result"></div>
  
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
    
  
    function getData(option){
      $.ajax({
        url: '/get-day',
        data: {
          option,
          param1: $('#prev-week-mon').data('date'),
          param2: $('#prev-week-mon').data('date')
        },
        success: function(data) {
          let html = ''
          $.each(data, function (index, element) {
            if (!element.length) {
              html += `<table style="margin-bottom: 2rem;">
                <thead id="head">
                </thead>
                <tbody>
                </tbody>
              </table>`
            }
  
            var table = $(`<table style="margin-bottom: 2rem;">`);
            var thead = $(`<thead id="head">`);
            var tbody = $("<tbody>");
  
            var row = ''
            let total = 0
            $.each(element, function (indexEl, data){ 
               row += `<tr>
                  <td><a href="/records/edit/option=${option}/id=${data.id}">${data?.category?.name}</a></td>
                  <td><a href="/records/edit/option=${option}/id=${data.id}">${data?.memo}</a></td>
                  <td><a href="/records/edit/option=${option}/id=${data.id}">¥${data?.yen}</a></td>
                </tr>`;
            
                total += data?.yen;
            });
            tbody.append(row);
  
            thead.append (
              `<tr>
                    <th>${index}</th>
                    <th></th>
                    <th>Total: ¥${total} </th
              </tr>`);
  
            table.append(thead, tbody);
  
            html+=table[0].outerHTML
          });
  
          $('#result').html(html);
        }
      });
    }
  </script>


  <footer>
    <a href="{{ route('records.create') }}">Record</a>
    <a class="daily" href="{{ route('day.index') }}">Daily</a>
    <a href="{{ route('month.index') }}">Monthly</a>
    <a href="{{ route('my_page.show', Auth::user()->id) }}">My Page</a>
  </footer>
</body>
</html>