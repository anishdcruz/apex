<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation\ {
    Main,
    Item,
    Term
};
use App\Counter;
use PDF;
use DB;

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
            'expiry_date' => 'required|date_format:Y-m-d',
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

        $quotation = DB::transaction(function() use ($request, $data, $items, $terms)
        {
            $quotation = new Main($data);
            $quotation->number = counter('quotation');
            $quotation->save();

            $quotation->items()->saveMany($items);

            $quotation->terms()->saveMany($terms);

            Counter::where('key', 'quotation')
                ->increment('number');

            return $quotation;
        });

        return response()
            ->json([
                'saved' => true
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

        if(request()->get('convert') == 'sales-order') {
            $quotation->number = counter('sales_order');
            $quotation->date = date('Y-m-d');
            $quotation->title = '';
            $quotation->customer_po = '';
        } else if(request()->get('convert') == 'invoice') {
            $number = $quotation->number;
            $quotation->number = counter('invoice');
            $quotation->date = date('Y-m-d');
            $quotation->due_date = '';
            $quotation->title = '';
            $quotation->reference = $number;
        } else if(request()->get('convert') == 'clone') {
            $quotation->number = counter('quotation');
            $quotation->date = date('Y-m-d');
            $quotation->expiry_date = '';
            $quotation->title = '';
            $quotation->reference = '';
        }

        return response()
            ->json([
                'form' => $quotation,
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
            'expiry_date' => 'required|date_format:Y-m-d',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'integer|exists:quotation_items,id,quotation_id,'.$id, // require for update
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'terms' => 'required|array|min:1',
            'terms.*.id' => 'integer|exists:quotation_terms,id,quotation_id,'.$id, // require for update
            'terms.*.description' => 'required|max:5000'
        ]);

        $quotation = Main::findOrFail($id);

        $items = [];
        $terms = [];

        $itemIds = [];
        $termIds = [];

        $subTotal = 0;

        foreach($request->items as $item) {
            if(isset($item['id'])) {
                Item::where('quotation_id', $quotation->id)
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
                Term::where('quotation_id', $quotation->id)
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

        $quotation->update($data);

        Item::whereNotIn('id', $itemIds)
            ->where('quotation_id', $quotation->id)
            ->delete();

        Term::whereNotIn('id', $termIds)
            ->where('quotation_id', $quotation->id)
            ->delete();

        if(count($items)) {
            $quotation->items()->saveMany($items);
        }

        if(count($terms)) {
            $quotation->terms()->saveMany($terms);
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


        $pdf = PDF::loadView('pdf.quotation', ['model' => $data]);

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

            case 'accepted':
                $model = Main::whereIn('status_id', [2, 4])
                    ->findOrFail($id);
                $model->status_id = 3;
                $model->save();
                break;

            case 'declined':
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
