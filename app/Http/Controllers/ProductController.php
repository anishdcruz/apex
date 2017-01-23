<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Counter;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'model' => Product::paginationOrderFilter()
            ]);
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $products = Product::with(['currency'])
            ->orderBy('created_at', 'desc')
            ->where(function($query) use ($q) {
                $query->where('item_code', 'like', '%.'.$q.'%')
                    ->orWhere('description', 'like', '%'.$q.'%')
                    ->orWhere('vendor_ref', 'like', '%'.$q.'%');
            })
            ->paginate(13);

        return response()
            ->json([
                'model' => $products
            ]);
    }

    public function create()
    {
        return response()
            ->json([
                'form' => Product::initialize(),
                'option' => [
                    'currencies' => currencies()
                ]
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'unit_price' => 'required|numeric|min:0',
            'vendor_ref' => 'required|max:255',
            'vendor_price' => 'required|numeric|min:0',
            'description' => 'required|max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        DB::transaction(function() {
            $product = new Product(request()->all());
            $product->item_code = counter('product');
            $product->save();

            Counter::whereKey('product')
                ->increment('number');
        });


        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $product = Product::with(['currency'])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $product
            ]);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return response()
            ->json([
                'form' => $product,
                'option' => [
                    'currencies' => currencies()
                ]
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'unit_price' => 'required|numeric|min:0',
            'vendor_ref' => 'required|max:255',
            'vendor_price' => 'required|numeric|min:0',
            'description' => 'required|max:2000',
            'currency_id' => 'required|integer|exists:currencies,id'
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return response()
            ->json([
                'saved' => true
            ]);
    }
}
