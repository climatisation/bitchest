<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CryptoList;
use \GuzzleHttp\Client;

class HomeController extends Controller
{

    protected $cryptos;
    protected $isAdmin;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->cryptos = CryptoList::all();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cryptos = CryptoList::all();
        // foreach ($cryptos as $crypto) {
        //     print_r($crypto->name);
        // }
        // echo User::isAdmin();
        echo 'printaa';
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        return view('crypto', ['crypto' => $cryptos, 'isAdmin' => $this->isAdmin]);
    }

    public function oneCrypto($id, Client $client) {

        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $response = $client->request('GET', "https://min-api.cryptocompare.com/data/v2/histoday?fsym=".$id."&tsym=EUR&limit=30", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
        $body = ($response->getStatusCode() === 200) ? $response->getBody() : 'error';

        $thirtyDays = [];
        $bodyArray = json_decode($body);
        foreach ($bodyArray->Data->Data as $item) {
            // no round if item < 1
            array_push($thirtyDays, $item->close > 1 ? round($item->close) : $item->close);
        }

        return view('crypto', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'thirtyDays' => $thirtyDays, 'currentCrypto' => $id]);
    }
}
