<?php
// Include the database configuration file  
require_once 'dbcon.php';


// Get the username from the session
$username = $_SESSION['auth_user']['username'];

// Get media data along with user details and profile picture from the database for the current user
$query = "
    SELECT 
        m.file_type AS media_file_type, 
        m.media, 
        m.username, 
        m.created,
        m.file_name AS media_file_name, 
        m.content,
        m.no_of_likes,
        m.no_of_comments,
        u.name,
        u.email,
        pp.file_type as profile_file_type,
        pp.content as profile_content
    FROM media m
    JOIN users u ON m.username = u.username
    LEFT JOIN profile_pictures pp ON u.username = pp.username
    WHERE m.username = ?
    ORDER BY m.id DESC
";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $con->error);
}

// Fetch all the results into an associative array
$user_timelineData = $result->fetch_all(MYSQLI_ASSOC);


?>