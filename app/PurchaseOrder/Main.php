<?php

namespace App\PurchaseOrder;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\Currency;
use App\Vendor;

class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'purchase_orders';

    public $type = 'Invoice';

    protected $fillable = [
        'title', 'vendor_id', 'currency_id', 'date',
        'status_id', 'discount', 'sub_total', 'total', 'amount_paid', 'reference',
    ];

    protected $filterFields = [
        'id', 'number', 'sub_total', 'total', 'title', 'vendor_id',
        'currency_id', 'date', 'status_id', 'amount_paid', 'reference',
        'discount', 'created_at',

        // filter relation
        'vendor.id', 'vendor.person', 'vendor.company', 'vendor.email', 'vendor.telephone',
        'vendor.billing_address', 'vendor.shipping_address', 'vendor.currency_id',
        'vendor.created_at'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'purchase_order_id', 'id');
    }

    public function terms()
    {
        return $this->hasMany(Term::class, 'purchase_order_id', 'id');
    }

    public static function initialize()
    {
        return [
            'vendor_id' => null , 'title' => 'Purchase Order for ',
            'number' => counter('purchase_order'), 'date' => date('Y-m-d'),
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
