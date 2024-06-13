<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Comments</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <form id="commentForm" action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="homepage">Homepage:</label>
            <input type="url" name="homepage" class="form-control" id="homepage">
        </div>
        <div class="form-group">
            <label for="text">Comment:</label>
            <textarea name="text" class="form-control" id="text" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control-file" id="image">
        </div>
        <div class="form-group">
            <label for="file">Text File:</label>
            <input type="file" name="file" class="form-control-file" id="file">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <h2 class="mt-5">All Comments</h2>
    <ul class="list-group" id="commentsList">
        <!-- Comments will be loaded here via AJAX -->
    </ul>

    <nav id="pagination">
        <!-- Pagination links will be loaded here via AJAX -->
    </nav>
</div>

<script src="{{ asset('js/ajax.js') }}"></script>

</body>
</html>
