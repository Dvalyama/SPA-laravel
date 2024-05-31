<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна</title>
    <style>
        /* Basic styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        textarea {
            width: 100%;
            height: 100px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Головна Сторінка</h1>

    <!-- Форма для додавання запису -->
    <form action="{{ route('submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="username">User Name (цифри і букви латинського алфавіту)</label>
            <input type="text" id="username" name="username" pattern="[A-Za-z0-9]+" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="homepage">Home page (необов'язкове)</label>
            <input type="url" id="homepage" name="homepage">
        </div>
        <div class="form-group">
            <label for="captcha">CAPTCHA</label>
            <img src="{{ route('captcha') }}" alt="CAPTCHA Image">
            <input type="text" id="captcha" name="captcha" pattern="[A-Za-z0-9]+" required>
        </div>
        <div class="form-group">
            <label for="text">Text (HTML теги не допустимі, крім дозволених)</label>
            <textarea id="text" name="text" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>

    <hr>

    <!-- Наявні коментарі -->
    @if($comments->count() > 0)
        <h3>Коментарі</h3>
        <ul>
            @foreach($comments as $comment)
                <li>{{ $comment->text }}</li>
            @endforeach
        </ul>
    @else
        <p>Поки що немає коментарів.</p>
    @endif
</div>

</body>
</html>
