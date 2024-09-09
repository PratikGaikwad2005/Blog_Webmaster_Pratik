document.addEventListener('DOMContentLoaded', function() {
    const postsPerPage = 5;
    let currentPage = 1;

    // Function to fetch posts
    function fetchPosts(page) {
        fetch(`fetch_posts.php?page=${page}&posts_per_page=${postsPerPage}`)
            .then(response => response.json())
            .then(data => {
                displayPosts(data.posts);
                setupPagination(data.total_pages, data.current_page);
            })
            .catch(error => console.error('Error fetching posts:', error));
    }

    // Function to display posts
    function displayPosts(posts) {
        const blogList = document.getElementById('blogList');
        blogList.innerHTML = '';

        posts.forEach(post => {
            const postElement = document.createElement('div');
            postElement.classList.add('blog-post');

            if (post.image) {
                const img = document.createElement('img');
                img.src = `uploads/${post.image}`;
                img.alt = 'Blog Image';
                postElement.appendChild(img);
            }

            const title = document.createElement('h2');
            title.textContent = post.title;
            postElement.appendChild(title);

            const description = document.createElement('p');
            description.textContent = post.description;
            postElement.appendChild(description);

            const readMore = document.createElement('a');
            readMore.href = `view_post.php?id=${post.id}`;
            readMore.textContent = 'Read More';
            postElement.appendChild(readMore);

            blogList.appendChild(postElement);
        });
    }

    // Function to set up pagination
    function setupPagination(totalPages, currentPage) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        if (currentPage > 1) {
            const prev = document.createElement('a');
            prev.href = '#';
            prev.textContent = '« Previous';
            prev.addEventListener('click', (e) => {
                e.preventDefault();
                fetchPosts(currentPage - 1);
            });
            pagination.appendChild(prev);
        }

        for (let i = 1; i <= totalPages; i++) {
            const page = document.createElement('a');
            page.href = '#';
            page.textContent = i;
            if (i === currentPage) {
                page.classList.add('active');
            } else {
                page.addEventListener('click', (e) => {
                    e.preventDefault();
                    fetchPosts(i);
                });
            }
            pagination.appendChild(page);
        }

        if (currentPage < totalPages) {
            const next = document.createElement('a');
            next.href = '#';
            next.textContent = 'Next »';
            next.addEventListener('click', (e) => {
                e.preventDefault();
                fetchPosts(currentPage + 1);
            });
            pagination.appendChild(next);
        }
    }

    // Event listener for the fetch button
    document.getElementById('fetchButton').addEventListener('click', () => {
        fetchPosts(currentPage);
    });

    // Initial fetch
    fetchPosts(currentPage);
});
