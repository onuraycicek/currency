<?php

namespace Onuraycicek\Currency;

use Illuminate\Support\Facades\DB;

class Currency
{
    public static function convertWithId($from_currency_id, $to_currency_id, $amount)
    {
        if ($from_currency_id == $to_currency_id) {
            return $amount;
        }

        $currency_rate = DB::table('currency_rates')->where('from_currency_id', $from_currency_id)->where('to_currency_id', $to_currency_id)->first();
        if ($currency_rate) {
            return $currency_rate->rate * $amount;
        }

        return false;
    }

    public static function convert($from_currency_code, $to_currency_code, $amount)
    {
        if ($from_currency_code == $to_currency_code) {
            return $amount;
        }

        $from_currency = DB::table('currencies')->where('code', $from_currency_code)->first();
        $to_currency = DB::table('currencies')->where('code', $to_currency_code)->first();
        if ($from_currency && $to_currency) {
            return self::convertWithId($from_currency->id, $to_currency->id, $amount);
        }

        return false;
    }
}
