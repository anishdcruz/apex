<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $model = Expense::with(['currency', 'vendor'])
            ->paginationOrderFilter();

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function create()
    {
        return response()
            ->json([
                'form' => Expense::initialize(),
                'option' => [
                    'currencies' => currencies(),
                    'vendors' => vendors()
                ]
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'vendor_id' => 'required|integer|exists:vendors,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'date' => 'required|date_format:Y-m-d',
            'amount' => 'required|numeric|min:0',
            'account' => 'required', // need to refactor
            'paid_through' => 'required', // also need to rf.
            'payment_reference' => 'max:255',
            'vendor_reciept' => 'max:255',
            'image' => 'mimes:jpeg,jpg,png|max:2000',
            'internal_note' => 'max:2000'
        ]);

        $expense = new Expense($request->except('image'));

        if ($request->hasfile('image') && $request->file('image')->isValid()) {
            // upload to images dir
            $filename = str_random(16).'.'.$request->image->extension();
            $path = $request->image->storeAs('images', $filename);
            $expense->image = $filename;
        }

        $expense->save();

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $po = Expense::with([
            'currency', 'vendor'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $po
            ]);
    }
}
