<?php

namespace App\Delivery;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\SalesOrder\Main as SalesOrder;
use App\Client;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'deliveries';

    protected $fillable = [
        'client_id', 'date', 'status_id', 'sales_order_id', 'address'
    ];

    protected $filterFields = [
        'id', 'client_id', 'date', 'status_id', 'sales_order_id', 'address',
        'created_at',
        // filter relation
        'client.id', 'client.person', 'client.company', 'client.email', 'client.telephone',
        'client.billing_address', 'client.shipping_address', 'client.currency_id',
        'client.created_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'delivery_id', 'id');
    }

    public function sales()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id', 'id');
    }
}
