<?php

namespace App\ReceivedPayment;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Currency;
use App\Client;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'received_payments';

    protected $fillable = [
        'client_id', 'amount_received', 'payment_date', 'payment_mode',
        'reference',  'amount_used', 'internal_note', 'currency_id'
    ];

    protected $filterFields = [
        'id', 'amount_received', 'payment_date', 'payment_mode',
        'reference',  'amount_used', 'number', 'internal_note',
        'created_at',

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
        return $this->hasMany(Item::class, 'received_payment_id', 'id');
    }

    public static function initialize()
    {
        return [
            'client_id' => '', 'amount_received' => 0, 'payment_date' => date('Y-m-d'),
            'payment_mode' => 'cheque', 'reference' => '',  'amount_used' => 0,
            'number' => counter('payment_received'), 'currency_id' => 1,
            'internal_note' => '',
            'items' => []
        ];
    }
}
