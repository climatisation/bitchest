<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CryptoList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto-list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('symbol');
            // $table->enum('crypto', ['bitcoin', 'ethereum', 'ripple', 'bitcoin cash', 'cardano', 'litecoin', 'nem', 'stellar', 'iota', 'dash']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto-list');
    }
}
