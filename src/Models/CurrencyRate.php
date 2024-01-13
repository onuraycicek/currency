<?php

namespace Onuraycicek\Currency\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
