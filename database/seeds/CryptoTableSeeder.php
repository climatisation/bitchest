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
        $cryptos = ['BTC','ETH','XRP','BCH','ADA','LTC','XEM','XLM','MIOTA','DASH'];

        foreach ($cryptos as $item) {
            DB::table('crypto-list')->insert([
                'name' => $item
            ]);
        }
        
        // DB::table('crypto-list')->insert([
        //     'name' => Str::random(10),
        //     'email' => Str::random(10).'@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);
    }
}
