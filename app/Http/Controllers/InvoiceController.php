<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice\ {
    Main,
    Item,
    Term
};
use App\Counter;
use PDF;
use DB;

class InvoiceController extends Controller
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
            'due_date' => 'required|date_format:Y-m-d',
            'reference' => 'max:255',
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

        $invoice = DB::transaction(function() use ($request, $data, $items, $terms)
        {
            $invoice = new Main($data);
            $invoice->number = counter('invoice');
            $invoice->save();

            $invoice->items()->saveMany($items);

            $invoice->terms()->saveMany($terms);

            Counter::where('key', 'invoice')
                ->increment('number');

            return $invoice;
        });

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function show($id)
    {
        $invoice = Main::with([
            'currency', 'client', 'items',
            'terms', 'payments.main.currency'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $invoice
            ]);
    }

    public function edit($id)
    {
        $invoice = Main::with([
            'items', 'terms'
            ])
            ->findOrFail($id);

        if(request()->get('convert') == 'clone') {
            $invoice->number = counter('invoice');
            $invoice->date = date('Y-m-d');
            $invoice->due_date = '';
            $invoice->title = '';
        }

        return response()
            ->json([
                'form' => $invoice,
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
            'due_date' => 'required|date_format:Y-m-d',
            'reference' => 'max:255',
            'discount' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'integer|exists:invoice_items,id,invoice_id,'.$id, // require for update
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'terms' => 'required|array|min:1',
            'terms.*.id' => 'integer|exists:invoice_terms,id,invoice_id,'.$id, // require for update
            'terms.*.description' => 'required|max:5000'
        ]);

        $invoice = Main::findOrFail($id);

        $items = [];
        $terms = [];

        $itemIds = [];
        $termIds = [];

        $subTotal = 0;

        foreach($request->items as $item) {
            if(isset($item['id'])) {
                Item::where('invoice_id', $invoice->id)
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
                Term::where('invoice_id', $invoice->id)
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

        $invoice->update($data);

        Item::whereNotIn('id', $itemIds)
            ->where('invoice_id', $invoice->id)
            ->delete();

        Term::whereNotIn('id', $termIds)
            ->where('invoice_id', $invoice->id)
            ->delete();

        if(count($items)) {
            $invoice->items()->saveMany($items);
        }

        if(count($terms)) {
            $invoice->terms()->saveMany($terms);
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


        $pdf = PDF::setOption('header-html', base_path('resources/views/static/header.html'))
            ->setOption('footer-html', base_path('resources/views/static/footer.html'))
            ->loadView('pdf.invoice', ['model' => $data]);

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

            case 'void':
                $model = Main::where('status_id', '>', 1)
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
