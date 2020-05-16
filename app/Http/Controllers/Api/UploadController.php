<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterventionImage;

class UploadController extends Controller
{
    private $movie_cover_path;

    public function __construct()
    {
        $this->movie_cover_path = config('uploads.movie_cover_path');
    }


    public function uploadImageCover(Request $request)
    {
        $cover = $request->file('cover');

        if (!is_dir($this->movie_cover_path)) {
            mkdir($this->movie_cover_path, 0744);
        }

        $image_name = date('YmdHis') . "_" . Str::random(8);
        $image_name_with_extension = $image_name . '.' . $cover->getClientOriginalExtension();

        if (InterventionImage::make($cover)->width() > 800) {
            $img = InterventionImage::make($cover)
                ->resize(800, null, function ($constraints) {
                    $constraints->aspectRatio();
                });
            $img->save($this->movie_cover_path . '/' . $image_name_with_extension);

        } else {
            $img = InterventionImage::make($cover);
            $img->save($this->movie_cover_path . '/' . $image_name_with_extension);
        }

        return $image_name_with_extension;
    }
}
