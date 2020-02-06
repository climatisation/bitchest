<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Crypto extends Controller
{

    public $client;
    public $response;

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client();
        $this->response = $this->client->request('GET', 'https://min-api.cryptocompare.com/data/pricemulti?fsyms=BTC,ETH,XRP,BCH,ADA,LTC,XEM,XLM,MIOTA,DASH&tsyms=EUR', ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
        // $this->middleware('auth');
    }

    public function index() {
        echo $this->response->getBody();
    }
}
