<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as InterventionImage;

class UploadController extends Controller
{
    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('movie_covers');
    }


    public function uploadImageCover(Request $request)
    {
        $cover = $request->file('cover');

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0744);
        }

        $image_name = date('YmdHis') . "_" . Str::random(8);
        $image_name_with_extension = $image_name . '.' . $cover->getClientOriginalExtension();

        if (InterventionImage::make($cover)->width() > 800) {
            $img = InterventionImage::make($cover)
                ->resize(800, null, function ($constraints) {
                    $constraints->aspectRatio();
                });
            $img->save($this->photos_path . '/' . $image_name_with_extension);

        } else {
            $img = InterventionImage::make($cover);
            $img->save($this->photos_path . '/' . $image_name_with_extension);
        }

        return $this->photos_path . DIRECTORY_SEPARATOR . $image_name_with_extension;
    }
}
