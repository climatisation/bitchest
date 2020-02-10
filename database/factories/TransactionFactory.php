<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;
use App\User;
use App\CryptoList;

$factory->define(Transaction::class, function (Faker $faker) {
    $cryptos = array(
        'BTC' => 'Bitcoin',
        'ETH' => 'Ethereum',
        'XRP' => 'Ripple',
        'BCH' => 'Bitcoin Cash',
        'ADA' => 'Cardano',
        'LTC' => 'Litecoin',
        'XEM' => 'NEM',
        'XLM' => 'Stellar',
        'MIOTA' => 'IOTA',
        'DASH' => 'Dash'
    );

    // echo App\CryptoList::all(['symbol'])->random()->symbol;

    // $cryptos[array_rand($cryptos)],

    return [
        'user_id' => App\User::all(['id'])->random(),
        // 'crypto' => $cryptos[array_rand($cryptos)],
        'crypto' => App\CryptoList::all(['symbol'])->random()->symbol,
        'purchase_value' => rand(10, 10000),
        'purchase_quantity' => rand(10, 10000),
        'sold' => false
    ];
});
