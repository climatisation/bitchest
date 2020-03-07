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

    // crypto quantity (purchase value = crypto price at buy moment, purchase quantity = euro spent)
    $purchase_value = rand(0, 10000);
    $purchase_quantity = rand(50, 10000);
    $crypto_quantity = ($purchase_quantity * 1) / $purchase_value;

    // add some transactions to admin
    $randomNumber = rand(0, 10);

    if ($randomNumber > 9) {
        return [
            'user_id' => 51,
            'crypto' => App\CryptoList::all(['symbol'])->random()->symbol,
            'purchase_value' => $purchase_value,
            'purchase_quantity' => $purchase_quantity,
            'crypto_quantity' => $crypto_quantity,
            'sold' => false
        ];
    } else {
        return [
        'user_id' => App\User::all(['id'])->random(),
        // 'crypto' => $cryptos[array_rand($cryptos)],
        'crypto' => App\CryptoList::all(['symbol'])->random()->symbol,
        'purchase_value' => $purchase_value,
        'purchase_quantity' => $purchase_quantity,
        'crypto_quantity' => $crypto_quantity,
        'sold' => false
    ];
    }
});
