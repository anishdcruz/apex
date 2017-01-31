<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vendor;

class VendorController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'model' => Vendor::paginationOrderFilter()
            ]);
    }

    public function create()
    {
        return response()
            ->json([
                'form' => Vendor::initialize(),
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
            'payment_details' => 'max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $vendor = Vendor::create($request->all());

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $vendor = Vendor::with(['currency'])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $vendor
            ]);
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        return response()
            ->json([
                'form' => $vendor,
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
            'payment_details' => 'max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());

        return response()
            ->json([
                'saved' => true
            ]);
    }
}
