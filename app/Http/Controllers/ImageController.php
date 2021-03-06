<?php

namespace App\Http\Controllers;

use App\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator,Redirect;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $baseURL = Images::getURLbase();
      $images = Images::all();
      if (count($images) != 0) {
        return view('images.index', ["images"=>$images, "baseURL"=>$baseURL]);
      } else {
        return view('images.index');
      }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Validate request
      request()->validate([
        'fileUpload' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      // Send request to be handled by Images model
      $fileEntry = Images::handleImage($request->file('fileUpload'));
      if ($fileEntry == "Success") {
        return Redirect::to("upload")
        ->withSuccess('Great! Image has been successfully uploaded.');
      } else {
        return Redirect::to("upload")->with('failed', $fileEntry);
      }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function show(Images $images, $id)
    {
      $baseURL = Images::getURLbase();
      $image = Images::getImg($id);
      return view('images.view', ["image"=>$image, "baseURL"=>$baseURL]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Images  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(Images $images, $id)
    {
      $deletedFile = Images::deleteImg($id);
      if ($deletedFile) {
        return Redirect::to("index")
        ->withSuccess('The image was successfully deleted and removed from s3.');
      } else {
        return Redirect::to("index")->with('failed', $deletedFile);
      }
    }
}
