<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $table = "requirements";
    protected $fillable = ['platform', 'minimum', 'recommended', 'post_id'];
}
