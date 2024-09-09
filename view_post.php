<?php
// Database credentials
$servername = "localhost";
$username = "root"; // Change this as necessary
$password = ""; // Change this as necessary
$dbname = "blogDB";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the post
$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if ($post): ?>
            <h1><?php echo htmlspecialchars($post['title']); ?></h1>
            <?php if ($post['image']): ?>
                <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="Blog Image">
            <?php endif; ?>
            <p><?php echo htmlspecialchars($post['description']); ?></p>
            <div><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
        <?php else: ?>
            <p>Post not found.</p>
        <?php endif; ?>
        <a href="index.php">Back to Blog List</a>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
