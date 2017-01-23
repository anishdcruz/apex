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
}
