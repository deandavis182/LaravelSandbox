<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Images extends Model
{
    public static function handleImage($imageFile) {
      // Creating path in s3 bucket
      $filePath = 'Images/'.str_replace(' ','_', $imageFile->getClientOriginalName());
      Storage::disk('s3')->put($filePath, file_get_contents($imageFile));
      if (Storage::disk('s3')->exists($filePath)) {
        $fileEntry = new self;
        $fileEntry->remoteFilePath = $filePath;
        if ($fileEntry->save()) {

          // Original image has been saved, now we will resize.
          $smallResize = Image::make($imageFile)->resize(350, null, function ($constraint) {
            $constraint->aspectRatio();
          })->encode($imageFile->getClientOriginalExtension());
          // Creating the new path
          $imageSmallPath = 'Images/'.str_replace(' ','_', 'SMALL-'.$imageFile->getClientOriginalName());
          Storage::disk('s3')->put($imageSmallPath, $smallResize);
          if (Storage::disk('s3')->exists($imageSmallPath)) {
            $fileEntry->small = $imageSmallPath;
            if ($fileEntry->save()) {

              // Now that we've made a smaller version of the original image, we will make the thumbnail
              $smallResize = Image::make($imageFile)->resize(150, null, function ($constraint) {
                $constraint->aspectRatio();
              })->encode($imageFile->getClientOriginalExtension());
              // Creating the new path
              $imageThumbPath = 'Images/'.str_replace(' ','_', 'THUMBNAIL-'.$imageFile->getClientOriginalName());
              Storage::disk('s3')->put($imageThumbPath, $smallResize);
              if (Storage::disk('s3')->exists($imageThumbPath)) {
                $fileEntry->thumbnail = $imageThumbPath;
                if ($fileEntry->save()) {
                  // Everything was uploaded and saved successfully
                  return 'Success';
                } else {
                    return "ERROR: Coudn't save the thumbnail image path to the DB!";
                }
              } else {
                  return "ERROR: Couldn't upload the thumbnail to s3!" ;
              }
            } else {
              return "ERROR: Coudn't save the small image path to the DB!";
            }
          } else {
            return "ERROR: Couldn't upload small image to s3!";
          }
        } else {
          return "ERROR: Couldn't save to the database!" ;
        }
      } else {
        return "ERROR: File wasn't stored in s3!";
      }
    }

    public static function getAllImgs() {
      return self::all();
    }

    // This will just return the base url to use for viewing the images in browser
    public static function getURLbase() {
      $img = self::first();
      if (!is_null($img)) {
        $bucketURL = Storage::disk('s3')->url($img->remoteFilePath);
        $parsedURL = str_replace($img->remoteFilePath, '', $bucketURL);
        return $parsedURL;
      } 
    }

    public static function getImg($ID) {
      $img = self::find($ID);
      if (!is_null($img)) {
        return $img;
      }
    }
}
