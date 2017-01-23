<?php
use App\Currency;

function currencies()
{
    return Currency::select('id', 'decimal_place', 'name', DB::raw('concat(code, " - " ,name) as text'))
        ->orderBy('code')->get()
        ->toArray();
}