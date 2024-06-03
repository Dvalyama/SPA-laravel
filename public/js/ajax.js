document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentForm');
    
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
                // Оновіть список коментарів за допомогою AJAX або перезавантажте сторінку
                console.log('Comment added successfully');
            } else {
                console.error('Failed to add comment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
