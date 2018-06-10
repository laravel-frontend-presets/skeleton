<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Show the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app', [
            'app_name' => 'auth',
            'config' => [
                'csrf_token' => csrf_token()
            ]
        ]);
    }
}
