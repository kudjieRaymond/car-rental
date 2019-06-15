<?php

namespace App\Traits;
use Illuminate\Http\Request;

trait FileUploadTrait {

     /**
     * File upload trait used in controllers to upload files
     */

    public function saveFiles(Request $request, $path){

        $upload_path = public_path($path);
        
        if(!file_exists($upload_path)){
            mkdir($upload_path, 0775, true) ;
        }

        $finalRequest = $request;
        foreach($request->all() as $key=>$value){
            if($request->hasFile($key)){
                $filename = time() . '-'. $request->file($key)->getClientOriginalName();
                $request->file($key)->move($upload_path, $filename);
               $finalRequest[$key] =  $filename ;
            }
        }
       
        return $finalRequest ; 

    }
}