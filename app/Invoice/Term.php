<?php

namespace App\Invoice;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'invoice_terms';

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
