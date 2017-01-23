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

    public function create()
    {
        return response()
            ->json([
                'form' => Client::initialize(),
                'option' => [
                    'currencies' => currencies()
                ]
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'person' => 'required|max:255',
            'company' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'max:255',
            'shipping_address' => 'required|max:2000',
            'billing_address' => 'required|max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $client = Client::create($request->all());

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $client = Client::with(['currency'])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $client
            ]);
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return response()
            ->json([
                'form' => $client,
                'option' => [
                    'currencies' => currencies()
                ]
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'person' => 'required|max:255',
            'company' => 'required|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'max:255',
            'shipping_address' => 'required|max:2000',
            'billing_address' => 'required|max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return response()
            ->json([
                'saved' => true
            ]);
    }
}
