<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Statement\ {
    Main,
    Item
};
use App\Invoice\Main as Invoice;
use App\ReceivedPayment\Main as Payment;
use App\Client;
use App\Counter;
use PDF;
use DB;

class StatementController extends Controller
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
            'from_date' => 'required|date_format:Y-m-d',
            'to_date' => 'required|date_format:Y-m-d'
        ]);

        $client = Client::findOrFail($request->client_id);

        $inv = DB::table('invoices')
            ->select([
                'date', 'number', DB::raw('"Invoice" as type'),
                'total as debits', DB::raw('0 as credits'), 'created_at'
                ])
            ->where('client_id', $client->id)
            ->whereBetween('date', [$request->from_date, $request->to_date]);

        $pay = DB::table('received_payments')
            ->select([
                'date', 'number', DB::raw('"Payment" as type'),
                DB::raw('0 as debits'), 'amount_received as credits', 'created_at'
            ])
            ->where('client_id', $client->id)
            ->whereBetween('date', [$request->from_date, $request->to_date])
            ->union($inv)
            ->orderBy('date')
            ->orderBy('created_at')
            ->get();

        $invSum = DB::table('invoices')
            ->where('client_id', $client->id)
            ->where('date', '<', $request->from_date)
            ->sum('total');

        $paySum = DB::table('received_payments')
            ->where('client_id', $client->id)
            ->where('date', '<', $request->from_date)
            ->sum('amount_received');

        $openingBalance = $invSum - $paySum;
        $items = [];
        $debit = 0;
        $credit = 0;
        $i = 0;
        $trs = $pay->toArray();

        foreach($trs as $tr) {
            if($i === 0) {
                if($tr->type == 'Payment') {
                    $tr->balance = $openingBalance - $tr->credits;
                } else {
                    $tr->balance = $openingBalance + $tr->debits;
                }
            } else {
                $prev = $trs[$i - 1];
                if($tr->type == 'Payment') {
                    $tr->balance = $prev->balance - $tr->credits;
                } else {
                    $tr->balance = $prev->balance + $tr->debits;
                }
            }

            $items[] = new Item((array)$tr);
            $debit += $tr->debits;
            $credit += $tr->credits;
            $i++;
        }

        $data = $request->all();
        $data['opening_balance'] = $openingBalance;
        $data['total'] = ($debit - $credit) + $openingBalance;

        $sales = DB::transaction(function() use ($request, $data, $items)
        {
            $sales = new Main($data);
            $sales->number = counter('statement');
            $sales->save();

            $sales->items()->saveMany($items);

            Counter::where('key', 'statement')
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
        $quotation = Main::with([
            'currency', 'client', 'items'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $quotation
            ]);
    }

    public function pdf($id, Request $request)
    {
        $data = Main::with([
            'currency', 'client', 'items'
            ])
            ->findOrFail($id);


        $pdf = PDF::setOption('header-html', base_path('resources/views/static/header.html'))
            ->setOption('footer-html', base_path('resources/views/static/footer.html'))
            ->loadView('pdf.statement', ['model' => $data]);

        $filename = "{$data->number}.pdf";

        if($request->get('opt') === 'download') {
            return $pdf->download($filename);
        }
        return $pdf->inline($filename);
    }
}
