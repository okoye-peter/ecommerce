<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PictureUpload extends Controller
{
    /**
     * mmove the image the user_profile_pics directory in the public folder
     * 
     * @param file $data
     * @return string image full path
     */
    static public function upload($data)
    {
        if (isset($data['avatar'])) {
            # code...
            return 'storage/'.$data['avatar']->store('userProfilePics', 'public');
        }
        return null;
    }
}
