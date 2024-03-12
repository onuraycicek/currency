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

    public static function getActiveCurrencies()
    {
        return DB::table('currencies')->where('status', 1)->get();
    }

    public static function getCurrency($currency_code)
    {
        return DB::table('currencies')->where('code', $currency_code)->first();
    }

    public static function getCurrencyById($currency_id)
    {
        return DB::table('currencies')->where('id', $currency_id)->first();
    }

    public static function convertByDate($from_currency_code, $to_currency_code, $amount, $date)
    {
        if ($from_currency_code == $to_currency_code) {
            return $amount;
        }

        $from_currency = DB::table('currencies')->where('code', $from_currency_code)->first();
        $to_currency = DB::table('currencies')->where('code', $to_currency_code)->first();
        if ($from_currency && $to_currency) {
            $currency_rate = DB::table('currency_dates')
                ->where('currency_id', $to_currency->id)
                ->where('query_date', $date)
                ->first();
            if ($currency_rate) {
                $to_rate = json_decode($currency_rate->currency_cross, true);
                if (isset($to_rate[$from_currency->id])) {
                    $to_rate = (float) $to_rate[$from_currency->id];

                    return $to_rate * $amount;
                }
            }
        }

        return false;
    }

    public static function convertByDateWithId($from_currency_id, $to_currency_id, $amount, $date)
    {
        if ($from_currency_id == $to_currency_id) {
            return $amount;
        }

        $currency_rate = DB::table('currency_dates')
            ->where('currency_id', $to_currency_id)
            ->where('query_date', $date)
            ->first();
        if ($currency_rate) {
            $to_rate = json_decode($currency_rate->currency_cross, true);
            if (isset($to_rate[$from_currency_id])) {
                $to_rate = (float) $to_rate[$from_currency_id];

                return $to_rate * $amount;
            }
        }

        return false;
    }
}
