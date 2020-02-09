<?php

use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Transaction::class, 50)->create()->each(function ($transaction) {
            $transaction->posts()->save(factory(App\Post::class)->make());
        });
    }
}
