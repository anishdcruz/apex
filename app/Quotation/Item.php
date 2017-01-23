<?php

namespace App\Quotation;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'quotation_items';

    protected $fillable = [
      'item_code', 'description',
      'unit_price', 'qty'
    ];

    public $timestamps = false;

    public static function initalize()
    {
        return [
            'item_code' => '', 'description' => '',
            'unit_price' => 0, 'qty' => 1
        ];
    }
}
