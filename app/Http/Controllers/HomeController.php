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

        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        // test all symbols history

        $cryptosData = [];

        foreach ($this->cryptos as $value) {
            $response = $this->client->request('GET', "https://min-api.cryptocompare.com/data/v2/histoday?fsym=".$value->symbol."&tsym=EUR&limit=30", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
            $body = ($response->getStatusCode() === 200) ? $response->getBody() : 'error';
            $bodyArray = json_decode($body);

            $cryptosData[$value->name] = [
                'symbol' => $value->symbol,
                'data' => [],
            ];

            foreach ($bodyArray->Data->Data as $item) {
                $cryptosData[$value->name]['data'][] = $item->close > 1 ? round($item->close) : $item->close;
            }
        }

        return view('home', ['crypto' => $this->cryptos, 'isAdmin' => $isAdmin, 'userHistory' => 0, 'multiCryptos' => $cryptosData]);
    }

    public function addMoney(Request $request) {

        $validatedData = $request->validate([
            'money' => 'required|numeric',
        ]);

        $user = Auth::user();
        $newBalance = $user->balance += floatval($request->input('money'));

        User::where('id', $user->id)->update([
            'balance' => $newBalance,
        ]);

        return back()->with('status', 'Your account was credited.');

    }

    public function oneCrypto($id) {

        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $response = $this->client->request('GET', "https://min-api.cryptocompare.com/data/v2/histoday?fsym=".$id."&tsym=EUR&limit=30", ['authorization' => '73741100522c6cd83adc3958daeab029b3c73e924eb4ab91aa3a34e0773c24f5']);
        $body = ($response->getStatusCode() === 200) ? $response->getBody() : 'error';

        $thirtyDays = [];
        $bodyArray = json_decode($body);
        foreach ($bodyArray->Data->Data as $item) {
            array_push($thirtyDays, $item->close);
        }
        
        $currentCrypto = array();
        $currentCrypto['symbol'] = $id;
        $currentCrypto['name'] = CryptoList::where('symbol', $id)->first()->name;

        $todayHistory = $this->getTodayCryptoValues();

        $euroBalance = $this->euroCryptoBalance($todayHistory);

        session([
            'user_id' => $user->id,
            'crypto_price' => $thirtyDays[count($thirtyDays) - 1],
            'crypto_name' => $currentCrypto['symbol'],
            'euro_balance' => $euroBalance
            ]);

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
            $gain = $currentCryptoQuantityInEuro - $value->purchase_quantity;
            $result[] = [
                'id' => $value->id,
                'crypto' => $value->crypto,
                'purchase_quantity' => $value->purchase_quantity,
                'purchase_value' => $value->purchase_value,
                'crypto_quantity' => $value->crypto_quantity,
                'sold' => $value->sold,
                'today_cryp_quant_eur' => $currentCryptoQuantityInEuro,
                'gain' => $gain,
            ];

        }

        return $result;

    }

    public function buyCrypto(Request $request) {

        $validatedData = $request->validate([
            'quantity' => 'required|numeric',
        ]);

        // checking if user have enough money
        $user = Auth::user();
        if ($user->balance >= floatval($request->input('quantity'))) {

            // update balance
            $newBalance = $user->balance - floatval($request->input('quantity'));
            User::where('id', $user->id)->update([
                'balance' => $newBalance,
            ]);

            $cryptoValueEuro = session('crypto_price');
            $cryptoSymbol = session('crypto_name');
            $quantityToBuy = floatval($request->input('quantity'));
            $crypto_quantity = (1 * $quantityToBuy) / $cryptoValueEuro;

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
        } else {
            $message = "YOU DON'T HAVE ENOUGH MONEY LOL";
            return redirect("/crypto/BTC")->with('status', $message);
        }

    }

    public function sell(Request $request) {

        $validatedData = $request->validate([
            'selected' => 'required|exists:transactions,id',
        ]);

        // update sold transactions
        Transaction::whereIn('id', $request->input('selected'))->update(['sold' => true]);

        // update user balance
        $user = Auth::user();
        $todayHistory = $this->getTodayCryptoValues();
        $euroBalance = $this->euroCryptoBalance($todayHistory);
        $diff = session('euro_balance') - $euroBalance;
        $newBalance = $user->balance + $diff;
        User::where('id', $user->id)->update([
            'balance' => $newBalance,
        ]);

        return back()->with('status', 'Sold successfully');

    }

    private function euroCryptoBalance($transactions) {
        $sum = 0;
        $numberOfTr = 0;
        foreach ($transactions as $transaction) {
            if (!$transaction['sold']) {
                $numberOfTr++;
                $sum += $transaction['today_cryp_quant_eur'];
            }
        }
        return $sum;
    }
}
