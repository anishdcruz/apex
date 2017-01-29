<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
class SettingsController extends Controller
{
    public function index()
    {
        return response()
            ->json([
                'document' => settings()->get('document')
            ]);
    }

    public function uploadDocument(Request $request)
    {
        $this->validate($request, [
            'header' => 'mimes:jpeg,jpg,png|max:2000',
            'footer' => 'mimes:jpeg,jpg,png|max:2000'
        ]);

        if ($request->hasfile('header') && $request->file('header')->isValid()) {

            $header = $this->toBase64($request->file('header'));

            settings()->set('document.header', $header);
            $this->createHTML($header, 'header.html');
        }

        if ($request->hasfile('footer') && $request->file('footer')->isValid()) {
            $footer = $this->toBase64($request->file('footer'));

            settings()->set('document.footer', $footer);
            $this->createHTML($footer, 'footer.html');
        }

        return response()
            ->json([
                'saved' => true
            ]);
    }

    private function toBase64($file)
    {
        $data = File::get($file->path());
        $base64 = 'data:image/' . $file->extension() . ';base64,' . base64_encode($data);
        return $base64;
    }

    private function createHTML($base64, $export)
    {
        $h = '<!doctype html>';
        $h .='<html>';
        $h .='<head>';
        $h .='    <meta charset="UTF-8">';
        $h .='</head>';
        $h .='<body>';
        $h .='</body>';
        $h .='    <img style="width: 100%;display: block;" src="'.$base64.'">';
        $h .='</html>';

        File::put(storage_path('app/'.$export), $h);
    }
}
