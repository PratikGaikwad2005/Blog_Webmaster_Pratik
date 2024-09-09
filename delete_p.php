<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file

// Fetch all posts
$stmt = $pdo->query('SELECT * FROM posts');
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <script>
        function confirmDelete(postId) {
            if (confirm('Are you sure you want to delete this post?')) {
                window.location.href = 'delete_post.php?id=' + postId;
            }
        }
    </script>
</head>
<body>
    <h1>Blog Posts</h1>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <?php echo htmlspecialchars($post['title']); ?> 
                <button onclick="confirmDelete(<?php echo $post['id']; ?>)">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
