<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to unbookmark posts.');
}

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']); // Ensure it's an integer
    $userId = $_SESSION['user_id'];

    // Prepare and execute the unbookmark query
    $stmt = $pdo->prepare('DELETE FROM bookmarks WHERE user_id = :user_id AND post_id = :post_id');
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect to the blog list page
        exit;
    } else {
        echo 'Error unbookmarking post.';
    }
} else {
    echo 'Invalid request.';
}
?>
