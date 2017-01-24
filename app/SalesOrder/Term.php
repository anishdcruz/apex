<?php

namespace App\SalesOrder;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'sales_order_terms';

    protected $fillable = [
        'description'
    ];

    public $timestamps = false;

    public static function initialize()
    {
        return [
            'description' => ''
        ];
    }
}
