<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GoogleSheetController extends Controller
{
    public function index()
    {
        $url = "https://script.google.com/macros/s/AKfycbwoMirhklBfkbmLzP8ogrLtbkXOsAZ9RG9DTbsOOmWuKL-whHfSvdFJ_lCdkD0wfphu/exec";

        $responses = Http::get($url)->json();

        return view(
            'responses.index',
            compact('responses')
        );
    }
}
