<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedemptionUsers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'redemption_users';


}
