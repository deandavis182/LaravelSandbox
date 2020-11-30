<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use App\Images;


class ImageTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
      // Making sure root domain is redirected
        $response = $this->get('/');
        $response->assertStatus(302);
    }

    public function testImageUpload()
    {
      // Testing image Upload
      $file = UploadedFile::fake()->image('avatar.jpg', 1024, 768)->size(750);
      $response = $this->json('POST', '/upload', [
            'fileUpload' => $file,
        ]);

      // Assert the files were stored...
      Storage::disk('s3')->assertExists('Images/'.$file->getClientOriginalName());
      Storage::disk('s3')->assertExists('Images/SMALL-'.$file->getClientOriginalName());
      Storage::disk('s3')->assertExists('Images/THUMBNAIL-'.$file->getClientOriginalName());

      // assert we have a DB entry
      $this->assertDatabaseHas('images', [
        'id' => '1',
      ]);

      $this->ImageDeleteTest();
    }

    public function ImageDeleteTest()
    {
      $response = $this->get('/image/delete/1');

      // Assert the files were deleted...
      Storage::disk('s3')->assertMissing('Images/avatar.jpg');
      Storage::disk('s3')->assertMissing('Images/SMALL-avatar.jpg');
      Storage::disk('s3')->assertMissing('Images/THUMBNAIL-avatar.jpg');

      // assert entry was removed from DB as files were deleted
      $this->assertDatabaseMissing('images', [
        'id' => '1',
      ]);
    }
}
