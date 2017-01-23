<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Term;

class TermController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->get('q', '');

        $terms = Term::orderBy('created_at', 'desc')
            ->where('description', 'like', '%'.$q.'%')
            ->paginate(10);

        return response()
            ->json([
                'model' => $terms
            ]);
    }
}
