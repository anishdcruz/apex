<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;

class Expense extends Model
{
    use PaginationOrderFilter;

    protected $fillable = [
        'vendor_id', 'currency_id', 'date', 'account', 'amount',
        'paid_through', 'payment_reference', 'vendor_receipt',
        'internal_note', 'image'
    ];

    protected $filterFields = [
        'id', 'date', 'account', 'amount',
        'paid_through', 'created_at',
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

    public static function initialize()
    {
        return [
            'vendor_id' => '', 'currency_id' => 1, 'date' => date('Y-m-d'), 'account' => 'expenses',
            'amount' => 0,'paid_through' => 'petty_cash', 'payment_reference' => '',
            'vendor_receipt' => '', 'internal_note' => '', 'image' => ''
        ];
    }
}
