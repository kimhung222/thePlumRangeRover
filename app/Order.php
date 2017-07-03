<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = ['name', 'type', 'payments', 'payment_account','facebook','email','tel','total','game_list'];
}
