<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function landingpage()
    {
        return view('welcome');
    }
}
