<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use \fzaninotto\faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();

        DB::table('users')->insert([
            'id' => 51,
            'name' => 'Vlad Edouard',
            'email' => 'vlad_pro@live.fr',
            'password' => Hash::make('admin'),
            'isAdmin' => true
        ]);
    }
}
