<?php

namespace App\Statement;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Client;
use App\Currency;
class Main extends Model
{
    protected $table = 'statements';

    use PaginationOrderFilter;

    protected $fillable = [
        'client_id', 'currency_id', 'from_date', 'to_date',
        'total', 'opening_balance'
    ];

    protected $filterFields = [
        'id', 'client_id', 'currency_id', 'from_date', 'to_date',
        'total', 'created_at',

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
        return $this->hasMany(Item::class, 'statement_id', 'id');
    }

    public static function initialize()
    {
        return [
            'client_id' => null,
            'number' => counter('statement'), 'from_date' => '2015-12-30', 'to_date' => date('Y-m-d'),
            'currency_id' => 1
        ];
    }
}
