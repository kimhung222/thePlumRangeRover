<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metacritic extends Model
{
    protected $table = "metacritics";
    protected $fillable = ['score', 'url', 'post_id'];
}
