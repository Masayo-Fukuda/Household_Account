<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Http\Request;

class MonthController extends Controller
{
    public function index()
    {
        $currentMonth= Carbon::now()->startOfMonth()->format('Y/m');
        return view('month', compact('currentMonth'));
    }

    public function getPrevMonth(Request $request)
    {
        $currentMonth = $request->input('param1');

        $prevMonth = Carbon::parse($currentMonth.'/01')->subMonth()->format('Y/m');
      
        return response()->json($prevMonth);
    }

    public function getNextMonth(Request $request)
    {
        $currentMonth = $request->input('param1');

        $nextMonth = Carbon::parse($currentMonth.'/01')->addMonth()->format('Y/m');
      
        return response()->json($nextMonth);
    }

    public function getData(Request $request)
    {
        $value = $request->input('option');
        $currentMonth = $request->input('param1');

        $monthStart = Carbon::parse($currentMonth.'/01')->format('Y/m/d');
        $monthEnd = Carbon::parse($currentMonth.'/01')->endOfMonth()->format('Y/m/d');
        $periods = CarbonPeriod::create(Carbon::parse($monthStart), Carbon::parse($monthEnd));
        $data = [];

        if ($value== 1) {

            $totalByCategory = Expense::where('user_id', Auth::id())->whereBetween('date', [$monthStart, $monthEnd])
            ->selectRaw('expense_category_id, SUM(yen) as total_sum')
            ->groupBy('expense_category_id')
            ->get()
            ->map(function ($category){
                $category['category_name'] = $category->category->name;
                
                return $category;

            });
            
        } else if ($value == 2) {

            $totalByCategory = Income::where('user_id', Auth::id())->whereBetween('date', [$monthStart, $monthEnd])
            ->selectRaw('income_category_id, SUM(yen) as total_sum')
            ->groupBy('income_category_id')
            ->get()
            ->map(function ($category){
                $category['category_name'] = $category->category->name;
                
                return $category;

            });

        } else {
            return response()->json(['message' => 'Invalid Option'], 422);
        }
        
        // データをJSON形式で返す
        return response()->json($totalByCategory);
    }
}
