<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bill\ {
    Main,
    Item
};
use App\Counter;
use App\PurchaseOrder\Main as PO;
use PDF;
use DB;

class BillController extends Controller
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

    public function create()
    {
        return response()
            ->json([
                'form' => Main::initialize(),
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
            'purchase_order_id' => 'integer|exists:purchase_orders,id',
            'vendor_invoice_no' => 'required|max:255',
            'date' => 'required|date_format:Y-m-d',
            'due_date' => 'required|date_format:Y-m-d',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        $items = [];

        $subTotal = 0;

        foreach($request->items as $item) {
            $items[] = new Item($item);
            $subTotal += $item['unit_price'] * $item['qty'];
        }

        $data = $request->except('items');
        $data['total'] = $subTotal;
        $data['status_id'] = 1;

        $bill = DB::transaction(function() use ($request, $data, $items)
        {
            $bill = new Main($data);
            $bill->number = counter('bill');
            $bill->save();

            $bill->items()->saveMany($items);

            Counter::where('key', 'bill')
                ->increment('number');

            if($request->has('purchase_order_id')) {
                PO::whereId($request->purchase_order_id)
                    ->update(['status_id' => 5]);
            }

            return $bill;
        });

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $bill = Main::with([
            'currency', 'vendor', 'items', 'purchase'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $bill
            ]);
    }
}
