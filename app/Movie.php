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

    public function getCover()
    {
        if (is_null($this->cover) or preg_match('/https?/', $this->cover)) {
            return $this->cover;
        }
        return config('uploads.movie_cover_path') . DIRECTORY_SEPARATOR . $this->cover;
    }

}
