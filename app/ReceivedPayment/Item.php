<?php

namespace App\ReceivedPayment;

use Illuminate\Database\Eloquent\Model;
use App\Invoice\Main as Invoice;
class Item extends Model
{
    protected $table = 'received_payment_items';

    protected $fillable = [
        'invoice_id', 'applied_amount'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function main()
    {
        return $this->belongsTo(Main::class, 'received_payment_id', 'id');
    }
}
