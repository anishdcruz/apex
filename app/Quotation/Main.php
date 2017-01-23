<?php

namespace App\Quotation;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Currency;
use App\Client;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'quotations';

    protected $fillable = [
        'title', 'client_id', 'currency_id', 'date', 'expiry_date',
        'status_id', 'discount', 'sub_total', 'total'
    ];

    protected $filterFields = [
        'id', 'number', 'sub_total', 'total', 'title', 'client_id',
        'currency_id', 'date', 'expiry_date', 'status_id',
        'discount', 'created_at',

        // filter relation
        'client.id', 'client.person', 'client.company', 'client.email', 'client.telephone',
        'client.billing_address', 'client.shipping_address', 'client.currency_id',
        'client.created_at'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'quotation_id', 'id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'quotation_id', 'id');
    }

    public static function initialize()
    {
        return [
            'client_id' => null , 'title' => 'Quotation for ',
            'number' => counter('quotation'), 'date' => date('Y-m-d'), 'expiry_date' => '',
            'currency_id' => 1, 'discount' => 0,
            'items' => [
                Item::initialize()
            ],
            'terms' => [
                Term::initialize()
            ]
        ];
    }
}
