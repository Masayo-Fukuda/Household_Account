<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use App\Models\Expense;
use App\Models\Income;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class DayController extends Controller
{
    public function index()
    {
        $currentWeekMonday = Carbon::now()->startOfWeek(Carbon::MONDAY)->format('Y/m/d');
        $currentWeekSunday = Carbon::now()->endOfWeek(Carbon::SUNDAY)->format('Y/m/d');
        return view('day', compact('currentWeekMonday','currentWeekSunday'));
    }

    public function getData(Request $request)
    {
        // フォームから送信されたオプション値を取得
        $value = $request->input('option');
        $currentWeekMonday = $request->input('param1');
        $currentWeekSunday = $request->input('param2');

        $prevWeekStart = Carbon::parse($currentWeekMonday)->format('Y/m/d');
        $prevWeekEnd = Carbon::parse($currentWeekSunday)->endOfWeek(Carbon::SUNDAY)->format('Y/m/d');
        $periods = CarbonPeriod::create(Carbon::parse($prevWeekStart), Carbon::parse($prevWeekEnd));
        $data = [];

        if ($value == 1) {

            foreach ($periods as $date) {
                $data[$date->format('Y/m/d')] = Expense::with('category')
                ->where('user_id', Auth::id())
                ->whereDate('date', $date)
                ->get();
            }
            
        } else if ($value == 2) {

            foreach ($periods as $date) {
                $data[$date->format('Y/m/d')] = Income::with('category')
                ->where('user_id', Auth::id())
                ->whereDate('date', $date)
                ->get();
            }

        } else {
            return response()->json(['message' => 'Invalid Option'], 422);
        }
        
        // データをJSON形式で返す
        return response()->json($data);
    }

    public function getPrevWeek(Request $request)
    {
        $currentWeekMonday = $request->input('param1');
        $currentWeekSunday = $request->input('param2');

        $prevWeekStart = Carbon::parse($currentWeekMonday)->subWeek()->format('Y/m/d');
        $prevWeekEnd = Carbon::parse($currentWeekSunday)->endOfWeek(Carbon::SUNDAY)->subWeek()->format('Y/m/d');
      
        return response()->json(['prevWeekStart' => $prevWeekStart, 'prevWeekEnd' => $prevWeekEnd]);
    }

    public function getNextWeek(Request $request)
    {
        $currentWeekMonday = $request->input('param1');
        $currentWeekSunday = $request->input('param2');

        $nextWeekStart = Carbon::parse($currentWeekMonday)->addWeek()->format('Y/m/d');
        $nextWeekEnd = Carbon::parse($currentWeekSunday)->endOfWeek(Carbon::SUNDAY)->addWeek()->format('Y/m/d');
      
        return response()->json(['nextWeekStart' => $nextWeekStart, 'nextWeekEnd' => $nextWeekEnd]);
    }
}
