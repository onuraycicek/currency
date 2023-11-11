<?php

namespace Onuraycicek\Currency\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;
use Onuraycicek\Currency\Facades\Currency;

class CurrenyTableComponent extends Component
{
    private $theme;
    public $currencies;
    public $currencyRates;
    private $filteredList;

    public function __construct()
    {
        $this->theme = config("currency.theme", "bootstrap5");
        $this->filteredList = config("currency.currencies", ["TRY","USD","EUR"]);

        $this->currencies = DB::table("currencies")->whereIn("code", $this->filteredList)->get();
        $this->currencyRates = DB::table("currency_rates")->when($this->filteredList, function($query, $filteredList) {
            foreach($filteredList as $currency) {
                $query->orWhere("from_currency_id", $this->currencies->where("code", $currency)->first()->id);
                $query->orWhere("to_currency_id", $this->currencies->where("code", $currency)->first()->id);
            }
        })->get();
    }

    public function render(): View
    {
        return view("currency::$this->theme.components.table");
    }
}