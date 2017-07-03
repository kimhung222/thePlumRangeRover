<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = "genres";
    protected $fillable = ['name', 'description'];

    public function posts() {
        return $this->belongsToMany('App\Post', 'post_has_genres');
    }
}
