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
                if ($from_currency_id == $to_currency_id || $rate == null) {
                    continue;
                }

                DB::table('currency_rates')->updateOrInsert([
                    'from_currency_id' => $from_currency_id,
                    'to_currency_id' => $to_currency_id,
                ], [
                    'rate' => $rate,
                ]);
            }
        }

        $active_currency_ids = $request->active_currency_ids;
        DB::table('currencies')->update([
            'status' => 0,
        ]);
        if ($active_currency_ids) {
            foreach ($active_currency_ids as $currency_id) {
                DB::table('currencies')->where('id', $currency_id)->update([
                    'status' => 1,
                ]);
            }
        }

        return redirect()->back()->withSuccess(__('Currency rates updated successfully.'));
    }

    public function select2(Request $request)
    {
        $q = $request->q;
        $currencies = DB::table('currencies')->where('code', 'like', '%'.$q.'%')->orWhere('name', 'like', '%'.$q.'%')->get();
        $data = [];
        foreach ($currencies as $currency) {
            $data[] = [
                'id' => $currency->id,
                'text' => $currency->code.' - '.$currency->name,
            ];
        }

        return response()->json($data);
    }
}
