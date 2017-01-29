<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesOrder\ {
    Main,
    Item,
    Term
};
use App\Counter;
use PDF;
use DB;

class SalesOrderController extends Controller
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

    public function create()
    {
        return response()
            ->json([
                'form' => Main::initialize(),
                'option' => [
                    'currencies' => currencies(),
                    'clients' => clients()
                ]
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'title' => 'required|max:255',
            'date' => 'required|date_format:Y-m-d',
            'customer_po' => 'max:255',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'terms' => 'required|array|min:1',
            'terms.*.description' => 'required|max:5000'
        ]);

        $items = [];
        $terms = [];

        $subTotal = 0;

        foreach($request->items as $item) {
            $items[] = new Item($item);
            $subTotal += $item['unit_price'] * $item['qty'];
        }

        foreach($request->terms as $term) {
            $terms[] = new Term($term);
        }

        $data = $request->except('items', 'terms');
        $data['sub_total'] = $subTotal;
        $data['total'] = $data['sub_total'] - $request->discount;
        $data['status_id'] = 1;

        $sales = DB::transaction(function() use ($request, $data, $items, $terms)
        {
            $sales = new Main($data);
            $sales->number = counter('sales_order');
            $sales->save();

            $sales->items()->saveMany($items);

            $sales->terms()->saveMany($terms);

            Counter::where('key', 'sales_order')
                ->increment('number');

            return $sales;
        });

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $model = Main::with([
            'currency', 'client', 'items', 'terms',
            'deliveries'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function edit($id)
    {
        $sales = Main::with([
            'items', 'terms'
            ])
            ->findOrFail($id);

        if(request()->get('convert') == 'invoice') {
            $number = $sales->number;
            $sales->number = counter('invoice');
            $sales->date = date('Y-m-d');
            $sales->due_date = '';
            $sales->title = '';
            $sales->reference = $number;
        }
        if(request()->get('convert') == 'delivery') {
            $sales->number = counter('delivery');
            $sales->client_name = "{$sales->client->person} - {$sales->client->company}";
            $sales->date = date('Y-m-d');
            $sales->address = $sales->client->shipping_address;
            $sales->sales_order_id = $sales->id;
            return response()
                ->json([
                    'form' => $sales,
                    'option' => []
                ]);
        }

        return response()
            ->json([
                'form' => $sales,
                'option' => [
                    'currencies' => currencies(),
                    'clients' => clients()
                ]
            ]);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'title' => 'required|max:255',
            'date' => 'required|date_format:Y-m-d',
            'customer_po' => 'max:255',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'integer|exists:sales_order_items,id,sales_order_id,'.$id, // require for update
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'terms' => 'required|array|min:1',
            'terms.*.id' => 'integer|exists:sales_order_terms,id,sales_order_id,'.$id, // require for update
            'terms.*.description' => 'required|max:5000'
        ]);

        $sales = Main::findOrFail($id);

        $items = [];
        $terms = [];

        $itemIds = [];
        $termIds = [];

        $subTotal = 0;

        foreach($request->items as $item) {
            if(isset($item['id'])) {
                Item::where('sales_order_id', $sales->id)
                    ->where('id', $item['id'])
                    ->update($item);

                $itemIds[] = $item['id'];
            } else {
                $items[] = new Item($item);
            }

            $subTotal += $item['unit_price'] * $item['qty'];
        }

        foreach($request->terms as $term) {
            if(isset($term['id'])) {
                Term::where('sales_order_id', $sales->id)
                    ->where('id', $term['id'])
                    ->update($term);

                $termIds[] = $term['id'];
            } else {
                $terms[] = new Term($term);
            }
        }

        $data = $request->except('items', 'terms');
        $data['sub_total'] = $subTotal;
        $data['total'] = $data['sub_total'] - $request->discount;

        $sales->update($data);

        Item::whereNotIn('id', $itemIds)
            ->where('sales_order_id', $sales->id)
            ->delete();

        Term::whereNotIn('id', $termIds)
            ->where('sales_order_id', $sales->id)
            ->delete();

        if(count($items)) {
            $sales->items()->saveMany($items);
        }

        if(count($terms)) {
            $sales->terms()->saveMany($terms);
        }

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function pdf($id, Request $request)
    {
        $data = Main::with([
            'currency', 'client', 'items', 'terms'
            ])
            ->findOrFail($id);

        $pdf = PDF::loadView('pdf.sales_order', ['model' => $data]);

        $filename = "{$data->number}.pdf";

        if($request->get('opt') === 'download') {
            return $pdf->download($filename);
        }
        return $pdf->inline($filename);
    }

    public function markAs($id, $type)
    {
        switch ($type) {
            case 'sent':
                $model = Main::whereStatusId(1)
                    ->findOrFail($id);
                $model->status_id = 2;
                $model->save();
                break;

            case 'open':
                $model = Main::whereIn('status_id', [2, 4])
                    ->findOrFail($id);
                $model->status_id = 3;
                $model->save();
                break;

            case 'close':
                $model = Main::whereIn('status_id', [2, 3])
                    ->findOrFail($id);
                $model->status_id = 4;
                $model->save();
                break;

            default:
                abort(404, 'Unknown Status');
                break;
        }

        return response()
            ->json([
                'saved' => true
            ]);
    }
}
