<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file
session_start();

// Fetch all posts
$stmt = $pdo->query('SELECT * FROM posts');
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch user's bookmarked posts
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('SELECT post_id FROM bookmarks WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $bookmarkedPosts = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
} else {
    $bookmarkedPosts = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <script>
        function toggleBookmark(postId, isBookmarked) {
            if (isBookmarked) {
                window.location.href = 'unbookmark_post.php?id=' + postId;
            } else {
                window.location.href = 'bookmark_post.php?id=' + postId;
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button onclick="toggleBookmark(<?php echo $post['id']; ?>, <?php echo in_array($post['id'], $bookmarkedPosts) ? 'true' : 'false'; ?>)">
                        <?php echo in_array($post['id'], $bookmarkedPosts) ? 'Unbookmark' : 'Bookmark'; ?>
                    </button>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="view_bookmarked_posts.php">View Bookmarked Posts</a>
    <?php endif; ?>
</body>
</html>
