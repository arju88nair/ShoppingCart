<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;

    protected $fillable = [
        'count', 'user_id', 'product_id'
    ];


}
