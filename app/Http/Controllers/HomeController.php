<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\CryptoList;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(CryptoList $cryptoList)
    {
        $cryptos = $cryptoList::all();
        foreach ($cryptos as $crypto) {
            print_r($crypto->name);
        }
//        echo User::isAdmin()<;
        echo 'printaa';
        $user = Auth::user();

//        print_r($user);
//        $result = $user->isAdmin();
        $lol = $user->isAdmin();
        print_r($lol);
        return view('crypto');
    }
}
