<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('api.index');
    }
}
