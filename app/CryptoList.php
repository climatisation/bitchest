<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CryptoList extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'crypto-list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    protected function getName () {
        return $this->name;
    }
}
