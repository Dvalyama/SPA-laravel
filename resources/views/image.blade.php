<form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
@csrf
  <div class="form-group">
     <label for="image_file">Image Input</label>
    <input type="file" name="image" id="image_file">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>