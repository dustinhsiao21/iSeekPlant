<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show home page.
     *
     * @return array
     */
    public function index()
    {
        return view('index');
    }
}
