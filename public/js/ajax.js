// ajax.js

// Функція для відправки даних форми через AJAX
function sendFormData(formData) {
    fetch('/comments', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Comment added successfully');
            // Оновити список коментарів
            fetchComments();
            // Очистити форму після успішного додавання коментаря
            document.getElementById('commentForm').reset();
            document.getElementById('captcha').src = '';
            document.getElementById('captcha').src = '/captcha?rand=' + Math.random();
        } else {
            console.error('Failed to add comment');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Функція для отримання списку коментарів через AJAX
function fetchComments() {
    fetch('/comments')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const commentsList = document.getElementById('commentsList');
        commentsList.innerHTML = '';
        data.comments.forEach(comment => {
            const commentItem = document.createElement('li');
            commentItem.classList.add('list-group-item');
            commentItem.innerHTML = `
                <strong>${comment.username}</strong> (${comment.email}) - ${new Date(comment.created_at).toLocaleString()}<br>
                ${comment.homepage ? `<a href="${comment.homepage}" target="_blank">${comment.homepage}</a><br>` : ''}
                ${comment.text}
                
                ${comment.image ? `<br><a href="${comment.image}" data-lightbox="roadtrip"><img src="${comment.image}" alt="Image" style="max-width: 50px; height: auto;"></a>` : ''}
                
                ${comment.file ? `<br><a href="${comment.file}" target="_blank">View File</a>` : ''}
            `;
            commentsList.appendChild(commentItem);
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('commentForm');
    
    commentForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        
        // Виклик функції для відправки даних форми через AJAX
        sendFormData(formData);
    });

    // Завантаження списку коментарів при завантаженні сторінки
    // fetchComments();
});
