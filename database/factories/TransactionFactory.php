<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

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
    return [
        'crypto' => $cryptos[rand(0, count($cryptos))],
        'purchase_value' => rand(10, 10000),
        'purchase_quantity' => rand(10, 10000),
        'sold' => false
    ];
});
