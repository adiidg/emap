<?php
// Include the database configuration file  
require_once 'dbcon.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "You need to login";
    header('Location: login.php');
    exit;
}

// Get media data along with user and profile picture details
$query = "SELECT media.file_type AS media_file_type, media.media, media.username, media.created, media.id, media.file_name AS media_file_name, media.content, media.no_of_likes, media.no_of_comments,
                 users.name, users.email, profile_pictures.file_type AS profile_file_type, profile_pictures.content AS profile_content
          FROM media 
          LEFT JOIN users ON media.username = users.username
          LEFT JOIN profile_pictures ON media.username = profile_pictures.username
          ORDER BY media.id DESC";

$result = $con->query($query);

if (!$result) {
    die("Query failed: " . $con->error);
}

// Fetch all the results into an associative array
$timelineData = $result->fetch_all(MYSQLI_ASSOC);


?>