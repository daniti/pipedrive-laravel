<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $token = Auth::user()->pipedrive_token->body();

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET',
            'https://api-proxy.pipedrive.com/deals',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token->access_token,
                    'Accept' => 'application/json',
                ]
            ]
        );

        $content=json_decode($res->getBody());

        $data = $content->data;

        return view('home')->with('data', $data);
    }
}
