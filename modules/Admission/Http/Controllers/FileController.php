<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function fileUser($user_id, $file) {
        // know you can have a mapping so you dont keep the sme names as in local (you can not precsise the same structor as the storage, you can do anything)

        // any permission handling or anything else

        // we check for the existing of the file
        $path = 'user_files/';
        if (!Storage::disk('local')->exists($path.$user_id.'/'.'admissions/'.$file)){ // note that disk()->exists() expect a relative path, from your disk root path. so in our example we pass directly the path (/…/laravelProject/storage/app) is the default one (referenced with the helper storage_path('app')
            // abort('404'); // we redirect to 404 page if it doesn't exist
           return response()->json(['Galat' => 'Dokumen tidak ditemukan'], 404);
        }
        //file exist let serve it
        
        // if there is parameters [you can change the files, depending on them. ex serving different content to different regions, or to mobile and desktop …etc] // repetitive things can be handled through helpers [make helpers]

        return response()->file(storage_path('app/user_files/'.$user_id.'/'.'admissions/'.$file)); // the response()->file() will add the necessary headers in our place (no headers are needed to be provided for images (it's done automatically) expected hearder is of form => ['Content-Type' => 'image/png'];

        // big note here don't use Storage::url() // it's not working correctly.
    }
}
