<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use File;
use Response;

class AppController extends Controller
{
    public function index()
    {
        if(Auth::check()) {
            return view('app');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|between:6,25'
        ]);

        $auth = Auth::attempt($request->only('email', 'password'), true);

        if(!$auth) {
            return redirect()
                ->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Invalid email or password combination!'
                ]);
        }

        return redirect()
            ->intended('/');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        Session::regenerate();

        return redirect('/');
    }

    public function image($filename)
    {
        $path = storage_path() . '/app/images/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
