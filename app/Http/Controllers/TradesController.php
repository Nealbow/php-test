<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Trades;
use Illuminate\Http\Request;


class TradesController extends Controller
{
    public function trades(Request $request)
    {
        try {
            $validated = $request->validate([
                'wallet' => 'required|string',
                'page' => 'required|integer|min:0|max:34'
            ]);
        } catch (\Exception $ex) {
            return [
                'success' => false,
                'message' => 'Validation error'
            ];
        }
        $data = Trades::getWalletTrades($validated['wallet'], $validated['page']);
        if ($data === false) {
            return [
                'success' => false,
                'message' => 'Binance API error'
            ];
        }
        return [
            'success' => true,
            'page' => intval($validated['page']),
            'data' => $data,
            'totalRows' => 500
        ];
    }
}
