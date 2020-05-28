<?php


namespace App\Http\Helpers;


use DateTime;
use Illuminate\Support\Facades\Http;

class Trades
{
    private static function getTransactionType($item) {
        if ($item['m']) return 'Покупка';
        return 'Продажа';
    }

    private static function remapFieldNames($item) {
        return [
            'time' => DateTime::createFromFormat('U', round($item['T']/1000))->format('l, d-M-Y G:i:s'),
            'type' => self::getTransactionType($item),
            'price' => doubleval($item['p']),
            'quantity' => doubleval($item['q'])
        ];
    }

    public static function getWalletTrades($wallet, $page) {
        $wallet = strtoupper($wallet);
        $response = Http::get("https://api.binance.com/api/v1/aggTrades?symbol={$wallet}");
        if ($response->failed()) return false;
        $reversed = array_reverse($response->json());
        $chunked = array_chunk($reversed, 15);
        return array_map('self::remapFieldNames', $chunked[$page]);
    }
}
