<?php

namespace App\utils;

use Faker\Provider\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class imageupload
{

    public function uploadimage($image)
    {
        // $image_name = Str::uuid() . date('YmdHis') . '.' . $image->getClientOriginalExtension();
        // Storage::disk('public')->put($image_name, file_get_contents($image));
        // return $image_name;
        $image_name = Str::uuid() . date('YmdHis') . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $image_name);
        return  $image_name;
    }
}
