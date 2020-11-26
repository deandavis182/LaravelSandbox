<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    @if ($image ?? '')
    <title>View Image</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
      .center {
        width: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
      }
      .carousel-control.right {
        color: black;
        background-image: none !important;
      }
      .carousel-control.left {
        color: black;
        background-image: none !important;
      }
    </style>
    @elseif (!$image)
    <title>404</title>
    @endif
  </head>
  <body>
    <a href="/index"><button style="font-size: larger;" type="button" name="button">Back to Index</button></a>
    @if ($image ?? '')
    <div class="container">
      <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
          <div class="item active">
            <h2 style="text-align: center;">Thumbnail</h2>
            <img src="{{$baseURL.$image->thumbnail}}" class="center">
          </div>

          <div class="item">
            <h2 style="text-align: center;">Small</h2>
            <img src="{{$baseURL.$image->small}}" class="center">
          </div>

          <div class="item">
            <h2 style="text-align: center;">Original</h2>
            <img src="{{$baseURL.$image->remoteFilePath}}" class="center">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
    @elseif (!$image)
    <h1>Image not found!</h1>
    @endif
  </body>
</html>
