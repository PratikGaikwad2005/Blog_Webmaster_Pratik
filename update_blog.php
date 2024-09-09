<?php
// Database connection
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blogId = $_GET['id'];
    $title = $_GET['title'];
    $description = $_GET['description'];
    $content = $_GET['content'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;
        
        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            echo "Failed to upload image!";
            exit;
        }
    } else {
        // If no new image is uploaded, keep the existing image
        $stmt = $pdo->prepare("SELECT image FROM posts WHERE id = ?");
        $stmt->execute([$blogId]);
        $blog = $stmt->fetch();
        $imagePath = $blog['image'];
    }
    
    // Update the blog post in the database
    $stmt = $pdo->prepare("
        UPDATE blogs 
        SET title = ?, description = ?, content = ?, image = ? 
        WHERE id = ?
    ");
    $result = $stmt->execute([$title, $description, $content, $imagePath, $blogId]);
    
    if ($result) {
        echo "Blog post updated successfully!";
        header('Location: view_blog.php?id=' . $blogId); // Redirect to the updated blog post
    } else {
        echo "Failed to update blog post!";
    }
} else {
    echo "Invalid request method!";
}
?>
