<?php

namespace App\Http\Controllers;
use App\Models\Currency;

use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public function getExchangeRate()
    {

        $app_id = env('API_ACCESS_KEY_ID');
        $oxr_url = "https://openexchangerates.org/api/latest.json?app_id=" . $app_id;

        // Open CURL session:
        $ch = curl_init($oxr_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Get the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $oxr_latest = json_decode($json);

        $rate_dollar_to_peso = $oxr_latest->rates->PHP;
        $rate_dollar_to_yen= $oxr_latest->rates->JPY;
        $peso = (1 / $rate_dollar_to_peso) * $rate_dollar_to_yen;
        $exchange_rate = round($peso, 3);
        // $date = $oxr_latest->timestamp;

        $currency = Currency::updateOrCreate(
            ['name' => 'PHP'],
            ['symbol' => '₽', 'exchange_rate' => $exchange_rate]
        );

        return $exchange_rate; // 為替レートを返す
    }
}
