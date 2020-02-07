<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \GuzzleHttp\Client;
use App\CryptoList;

class CryptoController extends Controller
{

    protected $response;

    public function __construct(Client $client)
    {
        // get all crypto prices
        $cryptoList = CryptoList::all();
        $cryptoListToQuery = array();
        foreach ($cryptoList as $crypto) {
            array_push($cryptoListToQuery, $crypto->symbol);
        }
        $cryptoSymbols = implode($cryptoListToQuery, ',');
        $this->response = $client->request('GET', "https://min-api.cryptocompare.com/data/pricemulti?fsyms=".$cryptoSymbols."&tsyms=EUR", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
        // $this->middleware('auth');
    }

    private function index() {}

    private function getCryptoList() {
        $cryptoList = CryptoList::all();
    }

    public function getPrices() {
        echo $this->response->getBody();

        echo 'lol';

    }

    public function oneCrypto($id) {
        echo $id;
    }
}
