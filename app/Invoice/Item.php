<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'invoice_items';

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
