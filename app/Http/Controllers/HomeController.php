<?php

namespace App\Http\Controllers;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pipedrive = app()->make('\Devio\Pipedrive\Pipedrive');
        return view('home')->with('data', $pipedrive->deals->all()->getData());
    }
}
