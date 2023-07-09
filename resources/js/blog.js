import axios from 'axios';

// Fetch all blog posts
axios.get('/api/posts')
    .then(response => {
        console.log(response.data);
        // Handle the response data here
    })
    .catch(error => {
        console.error(error);
        // Handle errors here
    });

// Fetch a specific blog post
axios.get('/api/posts/1')
    .then(response => {
        console.log(response.data);
        // Handle the response data here
    })
    .catch(error => {
        console.error(error);
        // Handle errors here
    });
