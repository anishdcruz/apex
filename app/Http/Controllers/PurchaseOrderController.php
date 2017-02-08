<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PurchaseOrder\ {
    Main,
    Item,
    Term
};
use App\Counter;
use PDF;
use DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $model = Main::with(['currency', 'vendor'])
            ->paginationOrderFilter();

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function show($id)
    {
        $po = Main::with([
            'currency', 'vendor', 'items',
            'terms',
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $po
            ]);
    }

    public function edit($id)
    {
        $po = Main::with([
            'items'
            ])
            ->findOrFail($id);

        if(request()->get('convert') == 'bill') {
            $temp = $po;
            $po->number = counter('bill');
            $po->date = '';
            $po->due_date = '';
            $po->vendor_invoice_no = '';
            $po->purchase_order_id = $temp->id;
        }

        return response()
            ->json([
                'form' => $po,
                'option' => [
                    'currencies' => currencies(),
                    'vendors' => vendors()
                ]
            ]);
    }
}
