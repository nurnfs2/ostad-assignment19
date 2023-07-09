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

<body style="background-image: url({{ asset('01.jpg') }})">

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


    <div class="container">

        <h1>Blog Posts</h1>

        <hr>

        <div class="container">

            <div id="postList" class="row">
                <!-- Posts will be dynamically added here -->
            </div>
        </div>

        <script>
            axios.get('/api/posts')
                .then(response => {
                    const posts = response.data;
                    const postList = document.getElementById('postList');

                    posts.forEach(post => {
                        const card = document.createElement('div');
                        card.classList.add('card', 'text-center', 'col-md-4', 'mb-3');

                        const cardBody = document.createElement('div');
                        cardBody.classList.add('card-body');

                        const title = document.createElement('h5');
                        title.classList.add('card-title');
                        title.textContent = post.title;

                        const content = document.createElement('p');
                        content.classList.add('card-text');
                        content.textContent = post.content;

                        const link = document.createElement('a');
                        link.href = `/blog/${post.id}`;
                        link.classList.add('btn', 'btn-primary');
                        link.textContent = 'Read More';

                        const footer = document.createElement('div');
                        footer.classList.add('card-footer', 'text-muted');
                        footer.textContent = '2 days ago';

                        cardBody.appendChild(title);
                        cardBody.appendChild(content);
                        cardBody.appendChild(link);
                        card.appendChild(cardBody);
                        card.appendChild(footer);

                        postList.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>

</html>
