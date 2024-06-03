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
    
    <form id="commentForm" action="{{ route('comments.store') }}" method="POST">
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    
    <h2 class="mt-5">All Comments</h2>
    <ul id="commentsList" class="list-group">
        @foreach (array_reverse($comments->toArray()) as $comment)
            <li class="list-group-item">
                <strong>{{ $comment['username'] }}</strong> ({{ $comment['email'] }})<br>
                @if ($comment['homepage'])
                    <a href="{{ $comment['homepage'] }}" target="_blank">{{ $comment['homepage'] }}</a><br>
                @endif
                {{ $comment['text'] }}
            </li>
        @endforeach
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commentForm = document.getElementById('commentForm');
        const commentsList = document.getElementById('commentsList');
        
        commentForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/comments', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Comment added successfully');
                    // Оновіть список коментарів за допомогою AJAX або перезавантажте сторінку
                    updateCommentsList();
                } else {
                    console.error('Failed to add comment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        function updateCommentsList() {
            fetch('/api/comments')
            .then(response => response.json())
            .then(comments => {
                // Очищаємо список коментарів
                commentsList.innerHTML = '';

                // Додаємо нові коментарі до списку
                comments.forEach(comment => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.innerHTML = `<strong>${comment.username}</strong> (${comment.email})<br>
                        ${comment.text}`;
                    
                    if (comment.homepage) {
                        const homepageLink = document.createElement('a');
                        homepageLink.href = comment.homepage;
                        homepageLink.target = '_blank';
                        homepageLink.textContent = comment.homepage;
                        listItem.appendChild(document.createElement('br'));
                        listItem.appendChild(homepageLink);
                    }
                    
                    commentsList.prepend(listItem);
                });
            })
            .catch(error => {
                console.error('Error updating comments:', error);
            });
        }

        // Оновлення списку коментарів при завантаженні сторінки
        updateCommentsList();
    });
</script>

</body>
</html>
