<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceivedPayment\ {
    Main,
    Item
};
use App\Counter;
use PDF;
use DB;

class ReceivedPaymentController extends Controller
{
    public function index()
    {
        $model = Main::with(['currency', 'client'])
            ->paginationOrderFilter();

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function show($id)
    {
        $payment = Main::with([
            'currency', 'client', 'items.invoice.currency'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $payment
            ]);
    }
}
