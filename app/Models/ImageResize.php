<?php

namespace App\Models;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageResize extends Model
{
    use HasFactory, SoftDeletes;

    // Functions ...
    public static function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }
    public static function cropImage($path, $width, $height)
    {
        // Memotong dengan ukuran 300x300 piksel mulai dari posisi x=50 dan y=50
        // $img->crop($width, $height, $x, $y);
        $img = Image::make($path);
        $img->crop($width, $height);
        $img->save($path);
    }

    public static function getFileImageSize($imagePath) {
        $info = getimagesize($imagePath); 
        if ($info === false) {
            return false;
        }
        $width = $info[0]; 
        $height = $info[1];
        return [
            'width' => $width,
            'height' => $height,
        ];
    }
    
}
