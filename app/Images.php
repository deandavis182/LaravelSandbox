<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Image;

class Images extends Model
{
    public static function handleImage($imageFile) {
      // Creating path for s3 bucket (everything will go in "/Images" directory within s3 bucket)
      $filePath = 'Images/'.str_replace(' ','_', $imageFile->getClientOriginalName());
      Storage::disk('s3')->put($filePath, file_get_contents($imageFile));

      // Make sure we have the file uploaded to s3
      if (!Storage::disk('s3')->exists($filePath)) {
        return "ERROR: File wasn't stored in s3!";
      }

      // Initiate new self model to start saving information to the DB
      $fileEntry = new self;
      $fileEntry->remoteFilePath = $filePath;

      // Save the current instance of model
      if (!$fileEntry->save()) {
        return "ERROR: Couldn't save to the database!" ;
      }

      // Original image has been saved, now we will resize.
      $smallResize = Image::make($imageFile)->resize(350, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode($imageFile->getClientOriginalExtension());

      // Creating the new path / file name
      $imageSmallPath = 'Images/'.str_replace(' ','_', 'SMALL-'.$imageFile->getClientOriginalName());
      Storage::disk('s3')->put($imageSmallPath, $smallResize);

      // Make sure we have the new file uploaded to s3
      if (!Storage::disk('s3')->exists($imageSmallPath)) {
        return "ERROR: Couldn't upload small image to s3!";
      }

      // Update our model instance and make sure it gets saved
      $fileEntry->small = $imageSmallPath;
      if (!$fileEntry->save()) {
        return "ERROR: Coudn't save the small image path to the DB!";
      }

      // Now that we've made a smaller version of the original image, we will make the thumbnail
      $smallResize = Image::make($imageFile)->resize(150, null, function ($constraint) {
        $constraint->aspectRatio();
      })->encode($imageFile->getClientOriginalExtension());

      // Creating the new path / file name
      $imageThumbPath = 'Images/'.str_replace(' ','_', 'THUMBNAIL-'.$imageFile->getClientOriginalName());
      Storage::disk('s3')->put($imageThumbPath, $smallResize);

      // Make sure we have the new file uploaded to s3
      if (!Storage::disk('s3')->exists($imageThumbPath)) {
        return "ERROR: Couldn't upload the thumbnail to s3!" ;
      }

      // Update our model instance and make sure it gets saved
      $fileEntry->thumbnail = $imageThumbPath;
      if (!$fileEntry->save()) {
        return "ERROR: Coudn't save the thumbnail image path to the DB!";
      }

      // If we're here, everything was uploaded and saved successfully
      return 'Success';
    }


    // This will just return the base url to use for viewing the images on the front end
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

    // Deleting s3 files + DB entry
    public static function deleteImg($ID) {
      $imgToDelete = self::find($ID);
      if (is_null($imgToDelete)) {
        return "ERROR: Image not found in the Database!";
      }

      if (!Storage::disk('s3')->delete($imgToDelete->remoteFilePath) || !Storage::disk('s3')->delete($imgToDelete->small) || !Storage::disk('s3')->delete($imgToDelete->thumbnail)) {
        return "ERROR: Couldn't remove the files from s3!";
      }

      if (!$imgToDelete->delete()) {
        return "ERROR: Couldn't remove the files from the database!";
      }

      return true;
    }
}
