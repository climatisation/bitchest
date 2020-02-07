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
        return view('crypto', ['crypto' => $cryptos, 'isAdmin' => $isAdmin]);
    }
}
