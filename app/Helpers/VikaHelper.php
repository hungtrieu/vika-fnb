<?php

namespace App\Helpers; // Your helpers namespace 

class VikaHelper
{
    public static function convertCurrency($amount): ?string
    {
        $currency_symbol = config('app.currency_unit');

        return (config('app.currency_position') ? '': $currency_symbol) . $amount . (config('app.currency_position') ? $currency_symbol : '');
    }
}