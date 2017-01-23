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
        'status_id', 'discount'
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
        return $this->hasMany(Item::class);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }
}
