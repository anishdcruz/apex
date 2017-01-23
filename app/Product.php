<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\PaginationOrderFilter;

class Product extends Model
{
    use PaginationOrderFilter;

    protected $fillable = [
        'description', 'unit_price', 'vendor_price',
        'vendor_ref', 'currency_id'
    ];

    protected $filterFields = [
        'id', 'item_code', 'unit_price', 'vendor_price',
        'vendor_ref', 'created_at'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public static function initialize()
    {
        return [
            'item_code' => counter('product'),
            'description' => '',
            'unit_price' => 0,
            'vendor_price' => 0,
            'vendor_ref' => '',
            'currency_id' => 1
        ];
    }
}
