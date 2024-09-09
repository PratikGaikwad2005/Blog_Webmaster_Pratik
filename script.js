document.getElementById('blogPostForm').addEventListener('submit', function(event) {
    let isValid = true;

    // Clear previous error messages
    document.getElementById('titleError').textContent = '';
    document.getElementById('descriptionError').textContent = '';
    document.getElementById('contentError').textContent = '';
    document.getElementById('imageError').textContent = '';

    // Validate title
    const title = document.getElementById('title').value.trim();
    if (title === '') {
        document.getElementById('titleError').textContent = 'Title is required.';
        isValid = false;
    }

    // Validate description
    const description = document.getElementById('description').value.trim();
    if (description === '') {
        document.getElementById('descriptionError').textContent = 'Description is required.';
        isValid = false;
    }

    // Validate content
    const content = document.getElementById('content').value.trim();
    if (content === '') {
        document.getElementById('contentError').textContent = 'Content is required.';
        isValid = false;
    }

    // Validate image
    const image = document.getElementById('image').files[0];
    if (!image) {
        document.getElementById('imageError').textContent = 'Image is required.';
        isValid = false;
    } else if (!image.type.startsWith('image/')) {
        document.getElementById('imageError').textContent = 'Please upload a valid image file.';
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});
