<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Crypto extends Controller
{
    public function __construct()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');
        $this->middleware('auth');
    }
}
