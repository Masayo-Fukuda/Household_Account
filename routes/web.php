<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\MyPageController;  
use App\Http\Controllers\DayController;  
use App\Http\Controllers\MonthController;
use App\Http\Controllers\ExchangeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('top', function () {
    return view('top');
});

Route::get('login_success', function () {
    return view('login_success');
});

Route::get('register_success', function () {
    return view('register_success');
});

Route::group(['middleware' => ['auth']], function () {

    // 保護されたルートの定義
    Route::get('/protected-page', [ProtectedController::class, 'index']);

    //Record
    Route::resource('records', RecordController::class);

    Route::get('/records/edit/option={option}/id={id}', [RecordController::class, 'edit'])->name('records.edit');

    Route::delete('/records/{option}/{id}', [RecordController::class, 'destroy'])->name('records.destroy');

    //My Page
    Route::get('/my_page/{id}', [MyPageController::class, 'show'])->name('my_page.show');

    //Day
    Route::get('day', [DayController::class, 'index'])->name('day.index');

    Route::get('/get-day', [DayController::class, 'getData']);

    Route::get('/prev-week', [DayController::class, 'getPrevWeek']);

    Route::get('/next-week', [DayController::class, 'getNextWeek']);

    //Month
    Route::get('month', [MonthController::class, 'index'])->name('month.index');

    Route::get('/get-month', [MonthController::class, 'getData']);

    Route::get('/prev-month', [MonthController::class, 'getPrevMonth']);
    
    Route::get('/next-month', [MonthController::class, 'getNextMonth']);

    //API
    Route::get('/exchange-rate', [ExchangeController::class, 'getExchangeRate']);
});