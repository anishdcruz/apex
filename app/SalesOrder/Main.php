<?php

namespace App\SalesOrder;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Currency;
use App\Client;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'sales_orders';

    protected $fillable = [
        'title', 'client_id', 'currency_id', 'date',
        'status_id', 'discount', 'sub_total', 'total', 'our_ref', 'customer_po'
    ];

    protected $filterFields = [
        'id', 'number', 'sub_total', 'total', 'title', 'client_id',
        'currency_id', 'date', 'status_id',
        'discount', 'created_at', 'our_ref', 'customer_po',

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
        return $this->hasMany(Item::class, 'sales_order_id', 'id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'sales_order_id', 'id');
    }

    public static function initialize()
    {
        return [
            'client_id' => null , 'title' => 'Sales Order for ',
            'number' => counter('sales_order'), 'date' => date('Y-m-d'),
            'currency_id' => 1, 'discount' => 0, 'our_ref' => null, 'customer_po' => null,
            'items' => [
                Item::initialize()
            ],
            'terms' => [
                Term::initialize()
            ]
        ];
    }
}
