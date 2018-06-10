<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app', [
            'app_name' => 'my',
            'config' => [
                'csrf_token' => csrf_token()
            ]
        ]);
    }
}
