<?php

use App\Currency;
use App\Counter;
use App\Client;
use App\Support\Settings;
use Carbon\Carbon;

function settings()
{
    return new Settings;
}

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

function formatMoney($amount, $currency, $code = false)
{
    $formatedAmount = number_format($amount, $currency->decimal_place);

    if($code) {
        return $formatedAmount . ' ' . $currency->code;
    }

    return $formatedAmount;
}

function formatDate($input, $format = 'd-M-Y')
{
    return Carbon::createFromFormat('Y-m-d', $input)->format($format);
}

function formatType($type)
{
    // violet #A769BF
    // light green #B0C165
    // red #E46A5D
    // orange #F1B14F
    // blue #71BCC2
    // pink #E05073
    // brown #8A5903
    // blue #1F6D9E
    // green #099145

    switch ($type) {
        case 'QUO':
            $color = '#B0C165';
            break;
        case 'INV':
            $color = '#E46A5D';
            break;
        case 'SAL':
            $color = '#71BCC2';
            break;
        case 'PRE':
            $color = '#8A5903';
            break;
        case 'DEL':
            $color = '#A769BF';
            break;
        case 'STM':
            $color = '#E05073';
            break;
        case 'PUO':
            $color = '#099145';
            break;
        default:
            $color = '#66cccc';
            break;
    }
    return 'style="background:'. $color .';"';
}
