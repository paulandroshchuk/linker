<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Client's index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __invoke()
    {
        return view('index.index');
    }
}
