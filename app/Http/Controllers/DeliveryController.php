<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Delivery\{
    Main,
    Item
};
use App\Counter;
use PDF;
use DB;

class DeliveryController extends Controller
{
    public function index()
    {
        $model = Main::with(['client', 'sales'])
            ->paginationOrderFilter();

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function show($id)
    {
        $model = Main::with([
            'sales', 'client', 'items'
            ])
            ->findOrFail($id);

        return response()
            ->json([
                'model' => $model
            ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'client_id' => 'required|integer|exists:clients,id',
            'sales_order_id' => 'required|integer|exists:sales_orders,id',
            'date' => 'required|date_format:Y-m-d',
            'address' => 'required|max:2000',
            'items' => 'required|array|min:1',
            'items.*.item_code' => 'required|alpha_dash|max:255',
            'items.*.description' => 'required|max:5000',
            'items.*.qty' => 'required|integer|min:1'
        ]);

        $items = [];

        foreach($request->items as $item) {
            $items[] = new Item($item);
        }

        $data = $request->except('items');
        $data['status_id'] = 1;

        $sales = DB::transaction(function() use ($request, $data, $items)
        {
            $sales = new Main($data);
            $sales->number = counter('delivery');
            $sales->save();

            $sales->items()->saveMany($items);

            Counter::where('key', 'delivery')
                ->increment('number');

            return $sales;
        });

        return response()
            ->json([
                'saved' => true
            ]);
    }

    public function pdf($id, Request $request)
    {
        $data = Main::with([
            'sales', 'client', 'items'
            ])
            ->findOrFail($id);


        // return view('pdf.delivery', ['model' => $data]);
        $pdf = PDF::loadView('pdf.delivery', ['model' => $data]);

        $filename = "{$data->number}.pdf";

        if($request->get('opt') === 'download') {
            return $pdf->download($filename);
        }
        return $pdf->inline($filename);
    }

    public function markAs($id, $type)
    {
        switch ($type) {
            case 'picked':
                $model = Main::whereStatusId(1)
                    ->findOrFail($id);
                $model->status_id = 2;
                $model->save();
                break;

            case 'delivered':
                $model = Main::whereStatusId(2)
                    ->findOrFail($id);
                $model->status_id = 3;
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
