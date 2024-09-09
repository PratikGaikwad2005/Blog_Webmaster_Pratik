
<?php
// Database connection
include('db_connect.php');

if (isset($_GET['id'])) {
    $blogId = $_GET['id'];
    
    // Fetch the blog post from the database
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$blogId]);
    $blog = $stmt->fetch();
    
    if (!$blog) {
        echo "Blog post not found!";
        exit;
    }
} else {
    echo "No blog ID specified!";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Blog Post</title>
</head>
<body>
    <h1>Edit Blog Post</h1>
    <form action="update_blog.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($blog['id']); ?>">
        
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($blog['description']); ?></textarea><br>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required><?php echo htmlspecialchars($blog['content']); ?></textarea><br>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br>
        
        <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="Current Image" width="200"><br>
        
        <button type="submit">Update Blog</button>
    </form>
</body>
</html>
