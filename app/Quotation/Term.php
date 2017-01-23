<?php

namespace App\Quotation;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'quotation_terms';

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
