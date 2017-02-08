<?php

namespace App\Bill;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'bill_items';

    protected $fillable = [
      'item_code', 'description',
      'unit_price', 'qty'
    ];

    public $timestamps = false;

    public static function initialize()
    {
        return [
            'item_code' => '', 'description' => '',
            'unit_price' => 0, 'qty' => 1
        ];
    }
}
