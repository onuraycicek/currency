<?php

namespace Onuraycicek\Currency\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController
{
    public function update(Request $request)
    {
        $currency_rate_values = $request->currency; // [from_currency_id][to_currency_id]
        foreach ($currency_rate_values as $from_currency_id => $to_currency_values) {
            foreach ($to_currency_values as $to_currency_id => $rate) {
                DB::table('currency_rates')->updateOrInsert([
                    'from_currency_id' => $from_currency_id,
                    'to_currency_id' => $to_currency_id,
                ], [
                    'rate' => $rate,
                ]);
            }
        }

        return redirect()->back()->withSuccess(__('Currency rates updated successfully.'));
    }
}
