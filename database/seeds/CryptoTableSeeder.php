<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CryptoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

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

        foreach ($cryptos as $key => $value) {
            DB::table('crypto-list')->insert([
                'name' => $value,
                'symbol' => $key
            ]);
        }
    }
}
