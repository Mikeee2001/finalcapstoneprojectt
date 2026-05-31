<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Vet;

abstract class Controller
{
    public function landingpage()
    {
        $services = Services::where('status', 'active')->get();

        $vet = Vet::with('specializations')
            ->where('status', 'active')
            ->get();
        //  dd($services);
        return view('welcome', compact('services', 'vet'));
    }
}
