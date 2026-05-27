<?php

namespace App\Http\Controllers;


class VetController extends Controller
{
    public function dashboard()
    {
        return view('vet.dashboard');
    }
}
