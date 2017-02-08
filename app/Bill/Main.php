<?php

namespace App\Bill;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;
use App\PurchaseOrder\Main as PO;
use App\Currency;
use App\Vendor;


class Main extends Model
{
    use PaginationOrderFilter;

    protected $table = 'bills';

    protected $fillable = [
        'vendor_id', 'currency_id', 'date', 'due_date', 'purchase_order_id',
        'vendor_invoice_no', 'status_id', 'total', 'amount_paid',
    ];

    protected $filterFields = [
        'id', 'number', 'vendor_id', 'currency_id', 'date', 'due_date', 'purchase_order_id',
        'vendor_invoice_no', 'status_id', 'total', 'amount_paid', 'created_at',

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
        return $this->hasMany(Item::class, 'bill_id', 'id');
    }

    public function purchase()
    {
        return $this->belongsTo(PO::class, 'purchase_order_id', 'id');
    }

    public static function initialize()
    {
        return [
            'vendor_id' => '',
            'number' => counter('bill'), 'date' => date('Y-m-d'), 'due_date' => '',
            'currency_id' => 1, 'vendor_invoice_no' => '',
            'items' => [
                Item::initialize()
            ]
        ];
    }
}
