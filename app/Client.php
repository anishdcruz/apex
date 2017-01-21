<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;

class Client extends Model
{
    use PaginationOrderFilter;

    protected $fillable = [
        'person', 'company', 'email', 'telephone', 'billing_address',
        'shipping_address', 'currency_id'
    ];

    protected $filterFields = [
        'id', 'person', 'company', 'email', 'telephone', 'billing_address',
        'shipping_address', 'currency_id', 'created_at'
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
            'currency_id' => 1
        ];
    }
}
