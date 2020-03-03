<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CryptoList;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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
        // $cryptos = CryptoList::all();
        // foreach ($cryptos as $crypto) {
        //     print_r($crypto->name);
        // }
        // echo User::isAdmin();
        // print_r($this->cryptos);
        // print_r($cryptos);
        $user = Auth::user();
        $isAdmin = $user->isAdmin();
        return view('crypto', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'currentCrypto' => $this->cryptos[0]]);
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
        
        $currentCrypto = array();
        $currentCrypto['symbol'] = $id;
        $currentCrypto['name'] = CryptoList::where('symbol', $id)->first()->name;

        // echo $user;
        $userTransactions = DB::table('transactions')->where('user_id', $user->id)->get();
        // print_r($userTransactions);

        print_r($userTransactions);

        // foreach ($userTransactions as $item) {
        //     print_r($item);
        // }

        return view('crypto', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'thirtyDays' => $thirtyDays, 'currentCrypto' => $currentCrypto]);
    }
}
