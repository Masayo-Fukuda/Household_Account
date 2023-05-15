<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomeCategory;
use App\Models\ExpenseCategory;
use App\Models\Expense;
use App\Models\Income;
use App\Service\ExchangeService;
use Illuminate\Support\Facades\Session;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $income_categories = IncomeCategory::all();
        $expense_categories = ExpenseCategory::all();

        return view('record', compact('income_categories', 'expense_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = Auth::id();

        $amount = $request->input('peso');
        $category_id = $request->input('category');
        $memo = $request->input('memo');
        $date = $request->input('date');

        if (empty($amount) || empty($category_id) || empty($date)) {
            Session::flash('error_message', 'There are missing entries in the data.');
            return redirect()->back();
        }

        $exchange_rate = ExchangeService::getExchangeRate();

        if ($request->input('q1') == 'expense') {
            $expense = new Expense();
            $expense->peso = $amount;
            $expense->yen = $amount * $exchange_rate;
            $expense->expense_category_id = $request->category;
            $expense->memo = $memo;
            $expense->date = $date;
            $expense->user_id = $user_id;
            $expense->save();
        }

        if ($request->input('q1') == 'income') {
            $income = new Income();
            $income->peso = $amount;
            $income->yen = $amount * $exchange_rate;
            $income->income_category_id = $category_id;
            $income->memo = $memo;
            $income->date = $date;
            $income->user_id = $user_id;
            $income->save();
        }

        Session::flash('success_message', 'Record successfully');

        return redirect('/records/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($option, $id)
    {
        $income_categories = IncomeCategory::all();
        $expense_categories = ExpenseCategory::all();

        if ($option == 1) {
            $record = Expense::findOrFail($id);
        } else if ($option == 2) {
            $record = Income::findOrFail($id);
        } else {
            return response()->json(['message' => 'Invalid Option'], 422);
        }
        
        return view('edit', compact('record', 'income_categories', 'expense_categories', 'option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $amount = $request->input('peso');
        $category_id = $request->input('category');
        $memo = $request->input('memo');
        $date = $request->input('date');
        $option = $request->input('option');
        $exchange_rate =app('App\Http\Controllers\ExchangeController')->getExchangeRate();

        if ($option == 1) {
            $record = Expense::find($id);
            $record->peso = $amount;
            $record->yen = $amount * $exchange_rate;
            $record->expense_category_id = $category_id;
            $record->memo = $memo;
            $record->date = $date;
            $record->save();
        } else if ($option == 2) {
            $record = Income::find($id);
            $record->peso = $amount;
            $record->yen = $amount * $exchange_rate;
            $record->income_category_id = $category_id;
            $record->memo = $memo;
            $record->date = $date;
            $record->save();
        } else {
            return response()->json(['message' => 'Invalid Option'], 422);
        }

        return redirect()->route('records.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($option, $id)
    {
        if ($option == 1) {
            $record = Expense::findOrFail($id);
        } else if ($option == 2) {
            $record = Income::findOrFail($id);
        } else {
            return response()->json(['message' => 'Invalid Option'], 422);
        }
    
        $record->delete();
    
        return redirect()->route('records.create');
    }
}
