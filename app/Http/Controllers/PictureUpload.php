<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JD\Cloudder\Facades\Cloudder;

class PictureUpload extends Controller
{
    /**
     * mmove the image the user_profile_pics directory in the public folder
     * 
     * @param file $data
     * @return string image full path
     */
    public static function uploadImages($data)
    {
        Cloudder::upload($data['avatar']);
        $cloundary_upload = Cloudder::getResult();

        return $cloundary_upload['url'];
    }
}
