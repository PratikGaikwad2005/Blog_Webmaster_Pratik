<?php
// Include database connection
include 'db_connect.php'; // Update with your actual database connection file

if (isset($_GET['id'])) {
    $postId = intval($_GET['id']); // Ensure it's an integer

    // Prepare and execute the deletion query
    $stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $stmt->bindParam(':id', $postId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php'); // Redirect to the blog list page after deletion
        exit;
    } else {
        echo 'Error deleting post.';
    }
} else {
    echo 'Invalid request.';
}
?>
