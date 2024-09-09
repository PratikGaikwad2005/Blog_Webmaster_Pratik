<?php
$servername = "localhost";
$username = "root"; // Change this as necessary
$password = ""; // Change this as necessary
$dbname = "blogdb";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = '';
    }

    $stmt = $conn->prepare("INSERT INTO posts (title, description, content, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $content, $image);

    if ($stmt->execute()) {
        echo "Blog post created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
