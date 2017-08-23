<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $fillable = [
        'type',
        'name',
        'appid',
        'required_age',
        'is_free',
        'detailed_description',
        'about_the_game',
        'short_description',
        'reviews',
        'header_image',
        'developer',
        'publisher',
        'recommendations',
        'support',
        'background',
        'is_released',
        'release_date',
        'current_price',
        'origin_price',
        'status',
        'card_price',
        'carousel_img',
        'is_on_discount',
        'is_popular',
        'show_tag',
        'is_new',
        'show_genres',
        'slug',
        'chosenRegion'
    ];
//    public function sluggable() {
//        return [
//            'slug' => [
//                'source' => 'slug',
//            ]
//        ];
//    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function categories() {
        return $this->belongsToMany('App\Category', 'post_has_categories');
    }

    public function genres() {
        return $this->belongsToMany('App\Genre', 'post_has_genres');
    }

    public function requirement() {
        return $this->hasOne('App\Requirement');
    }

    public function metacritic() {
        return $this->hasOne('App\Metacritic');
    }

    public function movies() {
        return $this->hasmany('App\Movie');
    }
}
