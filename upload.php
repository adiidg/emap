<?php
// Include the database configuration file  
require_once 'dbcon.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['authenticated'])) {
    echo "User is not logged in.";
    exit;
}

// If file upload form is submitted 
$statusMsg = '';
if (isset($_POST["submit"])) {
    if (!empty($_FILES["media"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["media"]["name"]);
        $fileType = mime_content_type($_FILES["media"]["tmp_name"]);

        // Get content description
        $contentDescription = $_POST["content"];

        // Allow certain file formats 
        $allowTypes = array('image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv');
        if (in_array($fileType, $allowTypes)) {
            // Get the username from the session
            $username = $_SESSION['auth_user']['username'];

            // Insert image content, username, and description into database using prepared statement
            $stmt = $con->prepare("INSERT INTO media (media, username, created, file_name, file_type, content) VALUES (?, ?, NOW(), ?, ?, ?)");
            $stmt->bind_param("bssss", $null, $username, $fileName, $fileType, $contentDescription);
            $stmt->send_long_data(0, file_get_contents($_FILES['media']['tmp_name'])); // Send the binary data

            if ($stmt->execute()) {
                header('Location: homepage1.php');
                exit(0);
            } else {
                $statusMsg = "File upload failed, please try again. Error: " . $stmt->error;
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, MP4, MOV, AVI, and WMV files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select a media file to upload.';
    }
} else {
    $statusMsg = 'File upload form is not submitted.';
}

// Display status message 
echo $statusMsg;
?>