<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;

class Vendor extends Model
{
    use PaginationOrderFilter;

    protected $fillable = [
        'person', 'company', 'email', 'telephone', 'billing_address',
        'shipping_address', 'currency_id', 'payment_details'
    ];

    protected $filterFields = [
        'id', 'person', 'company', 'email', 'telephone', 'billing_address',
        'shipping_address', 'currency_id', 'payment_details', 'created_at'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public static function initialize()
    {
        return [
            'person' => '',
            'company' => '',
            'email' => '',
            'telephone' => '',
            'billing_address' => '',
            'shipping_address' => '',
            'payment_details' => '',
            'currency_id' => 1
        ];
    }
}
