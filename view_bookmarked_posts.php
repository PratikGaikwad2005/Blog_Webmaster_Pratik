<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to view bookmarked posts.');
}

$userId = $_SESSION['user_id'];

// Fetch bookmarked posts
$stmt = $pdo->prepare('
    SELECT p.*
    FROM posts p
    JOIN bookmarks b ON p.id = b.post_id
    WHERE b.user_id = :user_id
');
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$bookmarkedPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookmarked Posts</title>
</head>
<body>
    <h1>Your Bookmarked Posts</h1>
    <ul>
        <?php foreach ($bookmarkedPosts as $post): ?>
            <li><?php echo htmlspecialchars($post['title']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
