<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleSheetController extends Controller
{
    public function index(Request $request)
    {
        $url = "https://script.google.com/macros/s/AKfycbwoMirhklBfkbmLzP8ogrLtbkXOsAZ9RG9DTbsOOmWuKL-whHfSvdFJ_lCdkD0wfphu/exec";
        
        $responses = collect(Http::get($url)->json());

        if ($request->filled('search')) {
            $search = Str::lower($request->search);

            $responses = $responses->filter(function ($row) use ($search) {
                foreach ($row as $value) {
                    if (Str::contains(Str::lower((string) $value), $search)) {
                        return true;
                    }
                }

                return false;
            })->values();
        }

        return view('responses.index', [
            'responses' => $responses,
        ]);
    }
}
