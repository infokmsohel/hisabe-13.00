<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 *
 * @author Shaju
 */
use Image;

trait FileUpload {
    //put your code here
    
    /*
     * Check The directory if Exists or nor
     */
    protected function CheckDir($dir) {
        if(!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        if(!file_exists($dir.'index.php')){
            $file = fopen($dir.'index.php','w');
            fclose($file);
        }
    }
    
   /*
    * Upload Image
    */
    protected function UploadImage($request,$fileName,$dir,$width,$height,$oldFile){
        if($this->CheckEnvirontment()){
            return null;
        }
        if(!$request->hasFile($fileName)){
            return $oldFile;
        }
        $this->CheckDir($dir);
        $this->RemoveFile($oldFile);
        
        $image = $request->file($fileName);
        $filename = $fileName.'_'.time().'.'.$image->getClientOriginalExtension();
        $path = $dir.$filename;
        Image::make($image)->resize($width,$height)->save($path);
        return $path;
    }
   
   /*
    * Remove File
    */
    protected function RemoveFile($filePath) {
        if(file_exists($filePath)){
            unlink($filePath);
        }
    }
    
    /*
     * Check EnvirentMent
     */
    protected function CheckEnvirontment() {
        if (config('app.env') == 'demo') {
            return false;
        }
    }
}
