<?php

namespace Onuraycicek\Currency\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class CurrenyTableComponent extends Component
{
    private $theme;

    public $currencies;

    public $currencyRates;

    public $selectActive;

    private $filteredList;

    public function __construct($selectActive = false)
    {
        $this->selectActive = $selectActive;
        $defaultCurrencies = ['TRY', 'USD', 'EUR'];
        $this->theme = config('currency.theme', 'bootstrap5');
        $this->filteredList = config('currency.currencies');

        if (empty($this->filteredList)) {
            $activeCurrencies = DB::table('currencies')->where('status', 1)->get();
            if ($activeCurrencies->count() > 0) {
                $this->filteredList = $activeCurrencies->pluck('code')->toArray();
            } else {
                $this->filteredList = $defaultCurrencies;
            }
        }

        $this->currencies = DB::table('currencies')->whereIn('code', $this->filteredList)->get();
        $this->currencyRates = DB::table('currency_rates')->when($this->filteredList, function ($query, $filteredList) {
            foreach ($filteredList as $currency) {
                $query->orWhere('from_currency_id', $this->currencies->where('code', $currency)->first()->id);
                $query->orWhere('to_currency_id', $this->currencies->where('code', $currency)->first()->id);
            }
        })->get();
    }

    public function render(): View
    {
        return view("currency::$this->theme.components.table");
    }
}
