<?php
session_start();
require_once 'dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media</title>
    <link rel="stylesheet" href="css/post.css">
</head>

<body>
    <?php
    if (!isset($_SESSION['authenticated'])) {
        echo "You are not logged in. Please log in first.";
        exit;
    }
    ?>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Select Media File:</label>
        <input type="file" name="media" required><br><br>
        <label>Content Description:</label>
        <textarea name="content" rows="4" cols="50" placeholder="Enter content description..."></textarea><br><br>
        <input type="submit" name="submit" value="Upload">
    </form>
</body>

</html>