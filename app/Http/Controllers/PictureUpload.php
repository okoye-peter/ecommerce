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
        Cloudder::upload($data);
        $cloundary_upload = Cloudder::getResult();

        return $cloundary_upload['url'];
    }

    public static function deleteImage($public_id){
        \Cloudinary::config(array(
            "cloud_name" => env('CLOUDINARY_CLOUD_NAME'),
            "api_key" => env("CLOUDINARY_API_KEY"),
            "api_secret" => env("CLOUDINARY_API_SECRET")
        ));
        $api = new \Cloudinary\Api();
        $response = $api->delete_resources($public_id);
        return response()->json(['msg'=>$response]);
    }
}
