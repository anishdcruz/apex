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
}
