<?php

namespace App\Delivery;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'deliveries_items';

    protected $fillable = [
      'item_code', 'description', 'qty'
    ];

    public $timestamps = false;
}
