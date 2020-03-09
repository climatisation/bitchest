<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;

class TradeController extends Controller
{
    public function __construct() {}

    public function index() {
        $user = Auth::user();
        $isAdmin = $user->isAdmin();

        $userTransactions = Transaction::where('user_id', $user->id)->get();
        return view('trade', ['isAdmin' => $isAdmin, 'userTransactions' => $userTransactions]);
    }
}
