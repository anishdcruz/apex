<?php

namespace App\Statement;

use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    protected $table = 'statement_items';

    public $timestamps = false;

     protected $fillable = [
        'date', 'type', 'number', 'debits', 'credits', 'balance'
    ];
}
