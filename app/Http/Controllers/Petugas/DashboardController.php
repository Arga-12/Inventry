<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //return view index
    public function index() {
        return view('petugas.dashboard');
    }
}
