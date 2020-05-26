<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


function get_type($item) {
    if ($item['m']) return 'Покупка';
    return 'Продажа';
}

function map_wallet_info($item)
{
    return [
        'time' => DateTime::createFromFormat('U', round($item['T']/1000))->format('l, d-M-Y G:i:s'),
        'type' => get_type($item),
        'price' => $item['p'],
        'quantity' => $item['q']
    ];
}

class TradesController extends Controller
{
    public function trades(Request $request)
    {
        $response = Http::get("https://api.binance.com/api/v1/aggTrades?symbol=ETHBTC&limit=15");
        if ($response->failed()) return response()->json(['success' => false], 400);
        return [
            'success' => true,
            'data' => array_map('App\Http\Controllers\map_wallet_info', $response->json()),
        ];
    }
}
