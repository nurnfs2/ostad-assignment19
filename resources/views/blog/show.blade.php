<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body style="background-image: url({{ asset('01.jpg') }});">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="{{ asset('logo.png') }}" style="height: 50px" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">



                    @if (Route::has('login'))

                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="nav-link">Home</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth

                    @endif
                </ul>

            </div>
        </div>
    </nav>
    <hr>


    <div class="container bg-light p-5">

    <h1 class="ptitle"></h1>
    <p></p>

    <hr>
    <h5>Comments: </h5>

    <ul id="commentList" class="list-group">
        <!-- Comments will be dynamically added here -->
    </ul>

    <hr>

    <div class="row">
        <div class="col-md-5">
            <form id="commentForm" class="mt-3">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Your Name">
                </div>
                <div class="form-group">
                    <textarea name="content" class="form-control" placeholder="Your Comment"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>
    </div>


    <hr>

    <a class="btn btn-primary" href="/">Back</a>


    </div>


    <script>
        // Fetch post details by id
        axios.get(`/api/posts/`+{{ $id }})
            .then(response => {
                const post = response.data;
                const ptitle = document.querySelector('.ptitle');
                const pcontent = document.querySelector('p');

                ptitle.textContent = post.title;
                pcontent.textContent = post.content;
            })
            .catch(error => {
                console.error(error);
            });


            // Fetch comments for the current post
        axios.get(`/api/posts/{{ $id }}/comments`)
            .then(response => {
                const comments = response.data;
                const commentList = document.getElementById('commentList');

                if (Array.isArray(comments)) {
                    comments.forEach(comment => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('list-group-item');
                        listItem.textContent = `${comment.name}: ${comment.content}`;

                        commentList.appendChild(listItem);
                    });
                }
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

            axios.post(`/api/posts/{{ $id }}/comments`, { name, content })
                .then(response => {
                    const newComment = response.data;
                    const commentList = document.getElementById('commentList');

                    const listItem = document.createElement('li');
                    listItem.classList.add('list-group-item');
                    listItem.textContent = `${newComment.name}: ${newComment.content}`;

                    commentList.appendChild(listItem);

                    commentForm.reset();
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
</script>

</body>
</html>
