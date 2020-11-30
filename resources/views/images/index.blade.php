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

    @if ($message = Session::get('success'))

    <div id="successMessage" class="alert alert-success alert-block">
        <strong>{{ $message }}</strong>
        <button type="button" onclick="hideSuccessMessage()" class="close" data-dismiss="alert">×</button>
    </div>
    <br>
    @endif
    @if ($message = Session::get('failed'))

    <div id="failedMessage" class="alert alert-success alert-block">
        <strong style="color:red">{{ $message }}</strong>
        <button type="button" onclick="hideFailedMessage()" class="close" data-dismiss="alert">×</button>
    </div>
    <br>
    @endif

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

    <script type="text/javascript">
      function hideSuccessMessage() {
        document.getElementById("successMessage").style.display = 'none';
      }
      function hideFailedMessage() {
        document.getElementById("failedMessage").style.display = 'none';
      }
    </script>
  </body>
</html>
