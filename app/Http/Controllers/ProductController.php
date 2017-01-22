<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'model' => Product::paginationOrderFilter()
            ]);
    }
}
