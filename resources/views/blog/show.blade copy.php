<!DOCTYPE html>
<html>
<head>
    <title>{{ $post->title }}</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>

    <h2>Comments</h2>
    <ul id="commentList">
        <!-- Comments will be dynamically added here -->
    </ul>

    <form id="commentForm">
        <input type="text" name="name" placeholder="Your Name">
        <textarea name="content" placeholder="Your Comment"></textarea>
        <button type="submit">Submit</button>
    </form>

    <script>
        // Fetch comments for the current post
        axios.get(`/api/posts/{{ $post->id }}/comments`)
            .then(response => {
                const comments = response.data;
                const commentList = document.getElementById('commentList');

                comments.forEach(comment => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${comment.name}: ${comment.content}`;

                    commentList.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error(error);
            });

        // Handle comment submission
        const commentForm = document.getElementById('commentForm');
        commentForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const formData = new FormData(commentForm);
            const name = formData.get('name');
            const content = formData.get('content');

            axios.post(`/api/posts/{{ $post->id }}/comments`, { name, content })
                .then(response => {
                    const newComment = response.data;
                    const commentList = document.getElementById('commentList');

                    const listItem = document.createElement('li');
                    listItem.textContent = `${newComment.name}: ${newComment.content}`;

                    commentList.appendChild(listItem);

                    commentForm.reset();
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
