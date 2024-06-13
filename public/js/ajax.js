// ajax.js

// Функція для відправки даних форми через AJAX
function sendFormData(formData) {
    fetch('/comments', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Comment added successfully');
            fetchComments();
            document.getElementById('commentForm').reset();
            document.getElementById('captcha').src = '/captcha?rand=' + Math.random();
            document.getElementById('parent_id').value = ''; // очищення parent_id
            document.getElementById('captcha_error').style = 'display:none';
        } else {
            console.error('Failed to add comment');
            document.getElementById('captcha').src = '/captcha?rand=' + Math.random();
            document.getElementById('captcha_error').style = 'display:block';
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
        Object.keys(data.comments).forEach(id => {
            const comment = data.comments[id].comment
            const commentItem = document.createElement('li');
            commentItem.classList.add('list-group-item');
            commentItem.style = `--depth:${data.comments[id].level}`
            commentItem.innerHTML = `
                <strong>${comment.username}</strong> (${comment.email}) - ${new Date(comment.created_at).toLocaleString()}<br>
                ${comment.homepage ? `<a href="${comment.homepage}" target="_blank">${comment.homepage}</a><br>` : ''}
                ${comment.text}
                ${comment.image ? `<br><a href="${comment.image}" data-lightbox="roadtrip"><img src="${comment.image}" alt="Image" style="max-width: 50px; height: auto;"></a>` : ''}
                ${comment.file ? `<br><a href="${comment.file}" target="_blank">View File</a>` : ''}
                <button class="btn btn-sm btn-primary reply-button" data-id="${comment.id}">Reply</button>
            `;
            commentsList.appendChild(commentItem);
        });

        // Attach event handlers for the reply buttons
        const replyButtons = document.querySelectorAll('.reply-button');
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const parentId = this.getAttribute('data-id');
                document.getElementById('parent_id').value = parentId;
            });
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

        sendFormData(formData);
    });

    fetchComments();
});
