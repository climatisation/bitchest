<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CryptoList;
use \GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use Debugbar;

class HomeController extends Controller
{

    protected $cryptos;
    protected $isAdmin;
    protected $client;
    protected $currentCryptoPrice;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->middleware('auth');
        $this->cryptos = CryptoList::all();
        $this->client = $client;
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
        return view('crypto', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'currentCrypto' => $this->cryptos[0], 'userHistory' => 0]);
    }

    public function oneCrypto($id) {

        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $response = $this->client->request('GET', "https://min-api.cryptocompare.com/data/v2/histoday?fsym=".$id."&tsym=EUR&limit=30", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
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

        session([
            'user_id' => $user->id,
            'crypto_price' => $thirtyDays[count($thirtyDays) - 1],
            'crypto_name' => $currentCrypto['symbol'],
            ]);

        echo 'sessionshit';

        $todayHistory = $this->getTodayCryptoValues();

        $euroBalance = $this->euroCryptoBalance($todayHistory);

        error_log('balance ');
        error_log($euroBalance);

        return view('crypto', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'thirtyDays' => $thirtyDays, 'currentCrypto' => $currentCrypto, 'userHistory' => $todayHistory, 'userBalance' => $euroBalance]);
    }

    private function getTodayCryptoValues() {

        $user = Auth::user();

        $userTransactions = DB::table('transactions')->where('user_id', $user->id)->get();
        $userTransactionsParsed = [];

        if (count($userTransactions) > 0) {
            $userCryptosArr = [];
            foreach ($userTransactions as $value) {
                $check = in_array($value->crypto, $userCryptosArr);
                // in array return string so not checking type
                if ($check != 1) {
                    $userCryptosArr[] = $value->crypto;                    
                }
            }
        } else {
            return null;
        }
        $userCryptosString = implode(',', $userCryptosArr);

        $response = $this->client->request('GET', "https://min-api.cryptocompare.com/data/pricemulti?fsyms=".$userCryptosString."&tsyms=USD,EUR", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
        $prices = ($response->getStatusCode() === 200) ? json_decode($response->getBody()) : 'error';

        $result = [];

        foreach ($userTransactions as $value) {
            $crypto = $value->crypto;
            $currentCryptoQuantityInEuro = $value->crypto_quantity * $prices->$crypto->EUR;
            // $gain = $value->purchase_quantity - $prices->$crypto->EUR;
            // $gain = $value->purchase_quantity - $currentCryptoQuantityInEuro;
            $gain = $currentCryptoQuantityInEuro - $value->purchase_quantity;
            error_log('purchase_quantity');
            error_log($value->purchase_quantity);
            error_log('price in eur, crypto quantity * price in eur');
            error_log($prices->$crypto->EUR);
            error_log($currentCryptoQuantityInEuro);
            $result[] = [
                'id' => $value->id,
                'crypto' => $value->crypto,
                'purchase_quantity' => $value->purchase_quantity,
                'purchase_value' => $value->purchase_value,
                'crypto_quantity' => $value->crypto_quantity,
                'sold' => $value->sold,
                'today_crypto_price' => $currentCryptoQuantityInEuro,
                'gain' => $gain,
            ];

        }

        return $result;

    }

    public function buyCrypto(Request $request, $id) {
        $cryptoValueEuro = session('crypto_price');
        $cryptoSymbol = session('crypto_name');
        error_log('session crypto value');
        $quantityToBuy = floatval($request->input('quantity'));
        $crypto_quantity = (1 * $quantityToBuy) / $cryptoValueEuro;
        error_log('input quantity : ');
        error_log($crypto_quantity);

        $transaction = new Transaction;
        $transaction->user_id = session('user_id');
        $transaction->crypto = $cryptoSymbol;
        $transaction->purchase_value = $cryptoValueEuro;
        $transaction->purchase_quantity = $quantityToBuy;
        $transaction->crypto_quantity = $crypto_quantity;
        $transaction->sold = false;
        $transaction->save();

        $message = "Successfully bought".strval($crypto_quantity)." ".$cryptoSymbol;

        return redirect("/crypto/".$cryptoSymbol)->with('status', $message);
    }

    public function sell(Request $request) {
        error_log('sell crypto received, ');
        foreach ($request->input('selected') as $value) {
            error_log('each input : ');
            error_log($value);
        }

        $shit = Transaction::whereIn('id', $request->input('selected'))->update(['sold' => true]);

        return $this->index();

        // $foo = Transaction::where('id', $request->input('selected'))->count();

        // error_log($foo);
        // if ($request->has('selected')) {
        //     error_log('has name');
        //     error_log($request->input('selected'));
        // }
        // if ($request->missing('selected')) {
        //     error_log('missing selected crypto');
        // }

        // Transaction::select();
        // error_log($request->input('selected'));
    }

    private function euroCryptoBalance($transactions) {
        $sum = 0;
        $numberOfTr = 0;
        foreach ($transactions as $transaction) {
            if (!$transaction['sold']) {
                $numberOfTr++;
                $sum += $transaction['today_crypto_price'];
            }
        }
        error_log('number of tr');
        error_log($numberOfTr);
        error_log($sum);
        return $sum;
    }
}
