<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation\ {
    Main,
    Item,
    Term
};

class QuotationController extends Controller
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
        $quotation = Main::with([
            'currency', 'client', 'items', 'terms'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $quotation
            ]);
    }

    public function edit($id)
    {
        $quotation = Main::with([
            'items', 'terms'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'form' => $quotation,
                'option' => [
                    'currencies' => currencies(),
                    'clients' => clients()
                ]
            ]);
    }
}
