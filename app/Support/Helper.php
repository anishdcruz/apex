<?php

use App\Currency;
use App\Counter;
use App\Client;

function currencies()
{
    return Currency::select('id', 'decimal_place', 'name', DB::raw('concat(code, " - " ,name) as text'))
        ->orderBy('code')->get()
        ->toArray();
}

function clients()
{
    return Client::select('id', 'currency_id', DB::raw('concat(person, " - " ,company) as text'))
        ->orderBy('person')->get()
        ->toArray();
}

function counter($key)
{
    $counter = Counter::whereKey($key)->firstOrFail();
    return "{$counter->prefix}{$counter->number}";
}