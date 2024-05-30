<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class ImageForm extends Controller
{
    public function store(Request $request)
    {
        $image = $request->file("image");
        //filename along with the extension
        $filename = $image->getClientOriginalName();
     
        //image resize logic
        $new_image = Image::make($image->getRealPath());

        if($new_image != null){
            $image_width= $new_image->width();
            $image_height= $new_image->height();
            $new_width= 320;
            $new_height= 240;
     
            $new_image->resize($new_width, $new_height, function    ($constraint) {
                   $constraint->aspectRatio();
            });
        }
        
    //saves the image into the public/storage/images folder
    $store_image = $new_image->save(public_path('images/' .$filename));
     
    //stores the image into the /storage/app/public/images folder
    //$store_image=&nbsp; Storage::put('images/' .$filename, (string) $image->encode());
     
    }
}
