<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <title>Upload Image</title>
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
    <h2>Image Upload </h2>
    <!-- Upload  -->
    <form id="image-upload-form" action="{{url('upload')}}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        @csrf
        <input id="file-upload" type="file" name="fileUpload" accept="image/*" required>
        <label for="file-upload" id="file-drag">
            <button type="submit" class="btn btn-success">Submit</button>
        </label>
    </form>

    <br>

    <a href="/index"><button type="button" name="button">View uploaded images</button></a>

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
