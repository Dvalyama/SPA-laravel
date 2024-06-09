<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Коментарі</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Коментарі</h1>
    
    @if (session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <form id="commentForm" action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="username">Ім'я користувача:</label>
            <input type="text" name="username" class="form-control" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="homepage">Домашня сторінка:</label>
            <input type="url" name="homepage" class="form-control" id="homepage">
        </div>
        <div class="form-group">
            <label for="captcha">CAPTCHA</label>
            <img src="{{ route('captcha') }}" alt="CAPTCHA Image" id="captcha">
            <input type="text" id="captcha_input" name="captcha" pattern="[A-Za-z0-9]+" required>
        </div>
        <div class="form-group">
            <label for="text">Коментар:</label>
            <textarea name="text" class="form-control" id="text" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Зображення:</label>
            <input type="file" name="image" class="form-control-file" id="image" accept=".jpg, .png">
        </div>
        <div class="form-group">
            <label for="file">Текстовий файл:</label>
            <input type="file" name="file" class="form-control-file" id="file" accept=".txt">
        </div>
        <input type="hidden" name="parent_id" id="parent_id">
        <button type="submit" class="btn btn-primary">Відправити</button>
    </form>
    
    <h2 class="mt-5">Всі коментарі</h2>
    <ul class="list-group" id="commentsList">
        <!-- Коментарі будуть завантажені тут -->
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox-plus-jquery.min.js"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
</body>
</html>
