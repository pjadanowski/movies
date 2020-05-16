<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title', 'cover', 'description', 'country_id'
    ];

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function genres() {
        return $this->belongsToMany(Genre::class);
    }

}
