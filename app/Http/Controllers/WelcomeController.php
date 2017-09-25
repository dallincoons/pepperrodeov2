<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
        if (!\Auth::check()) {
            return view('vendor.spark.auth.login');
        }

        return view('welcome');
    }
}
