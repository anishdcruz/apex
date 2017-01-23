<?php

use App\Currency;
use App\Counter;

function currencies()
{
    return Currency::select('id', 'decimal_place', 'name', DB::raw('concat(code, " - " ,name) as text'))
        ->orderBy('code')->get()
        ->toArray();
}

function counter($key)
{
    $counter = Counter::whereKey($key)->firstOrFail();
    return "{$counter->prefix}{$counter->number}";
}