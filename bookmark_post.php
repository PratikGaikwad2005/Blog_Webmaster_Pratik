<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to bookmark posts.');
}

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']); // Ensure it's an integer
    $userId = $_SESSION['user_id'];

    // Prepare and execute the bookmark query
    $stmt = $pdo->prepare('INSERT INTO bookmarks (user_id, post_id) VALUES (:user_id, :post_id) ON DUPLICATE KEY UPDATE id=id');
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect to the blog list page
        exit;
    } else {
        echo 'Error bookmarking post.';
    }
} else {
    echo 'Invalid request.';
}
?>
