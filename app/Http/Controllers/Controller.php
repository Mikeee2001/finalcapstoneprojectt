<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Vet;

abstract class Controller
{
    public function landingpage()
    {
        $services = Services::where('status', 'active')
            ->latest()
            ->paginate(6);

        $vet = Vet::with('specializations')
            ->where('status', 'active')
            ->get();

        return view('welcome', compact('services', 'vet'));
    }
}
