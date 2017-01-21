<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'model' => Client::paginationOrderFilter()
            ]);
    }
}
