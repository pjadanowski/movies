<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'genre_id', 'cover', 'description', 'country_id'
    ];

}
