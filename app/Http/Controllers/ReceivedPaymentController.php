<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReceivedPayment\ {
    Main,
    Item
};
use App\Invoice\Main as Invoice;
use App\Counter;
use PDF;
use DB;

class ReceivedPaymentController extends Controller
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

    public function show($id)
    {
        $payment = Main::with([
            'currency', 'client', 'items.invoice.currency'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $payment
            ]);
    }

    public function pdf($id, Request $request)
    {
        $data = Main::with([
            'currency', 'client', 'items.invoice.currency'
            ])
            ->findOrFail($id);


        $pdf = PDF::setOption('header-html', base_path('resources/views/static/header.html'))
            ->setOption('footer-html', base_path('resources/views/static/footer.html'))
            ->loadView('pdf.received_payment', ['model' => $data]);

        $filename = "{$data->number}.pdf";

        if($request->get('opt') === 'download') {
            return $pdf->download($filename);
        }
        return $pdf->inline($filename);
    }

    public function getInvoices($id)
    {
        $items = Invoice::with('currency')
            ->whereClientId($id)
            ->whereIn('status_id', [2, 5])
            ->get();

        $items->transform(function($item) {
            $item->invoice_id = $item->id;
            $item->amount_due = $this->getAmountDue($item);
            $item->applied_amount = 0;
            return $item;
        });

        return response()
            ->json([
                'items' => $items
            ]);
    }

    private function getAmountDue($item)
    {
        return $item->total - $item->amount_paid;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'currency_id' => 'required|integer|exists:currencies,id',
            'amount_received' => 'required|numeric|min:1',
            'date' => 'required|date_format:Y-m-d',
            'payment_mode' => 'required|in:Cheque,Cash,Bank_transfer',
            'reference' => 'required|max:255',
            'internal_note' => 'max:2000',
            'items' => 'required|array|min:1',
            'items.*.invoice_id' => 'required|exists:invoices,id',
            'items.*.applied_amount' => 'required|numeric|min:0',
            'items.*.amount_due' => 'required|numeric|min:0'
        ]);

        $sum = 0;
        $amountDue = 0;
        $items = [];

        foreach($request->items as $item) {
            if($item['applied_amount'] > 0) {
                $sum += $item['applied_amount'];
                $amountDue += $item['amount_due'];
                $items[] = new Item($item);
            }
        }

        if($request->amount_received != $sum || $request->amount_received > $amountDue) {
            return response()
                ->json([
                    'amount_received' => [
                        'Sum of applied amount is not equal to amount received.'
                    ]
                ], 422);
        }

        DB::transaction(function() use ($sum, $items) {
            $data = request()->except('items');

            // create payment
            $payment = new Main($data);
            $payment->number = counter('payment_received');
            $payment->amount_received = $sum;
            $payment->amount_used = $sum;
            $payment->save();

            // create items
            $payment->items()->saveMany($items);

            // update counter
            Counter::where('key', 'payment_received')
                ->increment('number');

            // update associated invoices
            foreach($payment->items as $item) {
                $item->load('invoice');
                $item->invoice->amount_paid = $item->invoice->amount_paid + $item->applied_amount;
                $item->invoice->status_id = 5;

                if($item->invoice->amount_paid == $item->invoice->total) {
                    $item->invoice->status_id = 3;
                }

                $item->invoice->save();
            }
        });
    }
}
