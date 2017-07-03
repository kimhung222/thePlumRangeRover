<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ['name', 'description'];

    public function posts() {
        return $this->belongsToMany('App\Post', 'post_has_categories');
    }
}
