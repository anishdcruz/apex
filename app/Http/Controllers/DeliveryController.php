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

    public function pdf($id, Request $request)
    {
        $data = Main::with([
            'sales', 'client', 'items'
            ])
            ->findOrFail($id);


        // return view('pdf.delivery', ['model' => $data]);
        $pdf = PDF::setOption('header-html', base_path('resources/views/static/header.html'))
            ->setOption('footer-html', base_path('resources/views/static/footer.html'))
            ->loadView('pdf.delivery', ['model' => $data]);

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
