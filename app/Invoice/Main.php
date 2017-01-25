<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Currency;
use App\Client;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'invoices';

    protected $fillable = [
        'title', 'client_id', 'currency_id', 'date', 'due_date',
        'status_id', 'discount', 'sub_total', 'total', 'amount_paid', 'reference'
    ];

    protected $filterFields = [
        'id', 'number', 'sub_total', 'total', 'title', 'client_id',
        'currency_id', 'date', 'due_date', 'status_id', 'amount_paid', 'reference',
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
        return $this->hasMany(Item::class, 'invoice_id', 'id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'invoice_id', 'id');
    }

    public static function initialize()
    {
        return [
            'client_id' => null , 'title' => 'Invoice for ',
            'number' => counter('quotation'), 'date' => date('Y-m-d'), 'due_date' => '',
            'currency_id' => 1, 'discount' => 0, 'reference' => null,
            'items' => [
                Item::initialize()
            ],
            'terms' => [
                Term::initialize()
            ]
        ];
    }
}
