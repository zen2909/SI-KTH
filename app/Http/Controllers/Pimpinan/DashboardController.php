<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pimpinan.index');
    }
}
