<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <title>Images</title>
    <style type="text/css">
      .thumbDivs {
        padding: .5em;
        margin: .5em;
        border: solid black 2px;
      }
      .thumbContainer {
        display: inline-flex;
      }
    </style>
  </head>
  <body>
    @if ($images ?? '')
      <p> We have {{ count($images ?? '') }} Images!</p>
      <p>(Click an image to see the generated versions of each image.)</p>
      <br>
      <a href="/upload"><button style="font-size: larger;" type="button" name="button">Add more images</button></a>
      <br>
      <br>
      <div class="thumbContainer">
      @foreach ($images as $image)
        <a href="/image/{{$image->id}}">
          <div class="thumbDivs">
            <img src="{{$baseURL.$image->thumbnail}}"/>
          </div>
        </a>
      @endforeach
      </div>
    @else
      <p>There are no images uploaded yet! </p> <a href="/upload"><button style="font-size: larger;" type="button" name="button">Upload Images</button></a>
    @endif
  </body>
</html>
