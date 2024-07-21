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

// Include this part in others_profile_get.php after fetching user data
if (isset($_SESSION['follow_request'])) {
    echo $_SESSION['follow_request'];
    unset($_SESSION['follow_request']);  // Clear the message after displaying it
}

// Get the username from the session
$username = $_SESSION['auth_user']['username'];

// Get user data from the database
$stmt = $con->prepare("SELECT u.name, u.about_me, p.file_type AS profile_pic_type, p.content AS profile_pic_content FROM users u LEFT JOIN profile_pictures p ON u.username = p.username WHERE u.username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$userData = $result->fetch_assoc();

if ($userData) {
    // Set default values if name or profile picture does not exist
    $name = $userData['name'] ?? "Your Name";
    if ($userData['profile_pic_content']) {
        $profilePicType = $userData['profile_pic_type'];
        $profilePicContent = base64_encode($userData['profile_pic_content']);
        $profilePicSrc = 'data:' . $profilePicType . ';base64,' . $profilePicContent;
    } else {
        // Get the content of the default profile picture
        $defaultPicPath = 'default/default.png';
        $profilePicSrc = $defaultPicPath;
    }

    // Store user data in session for use in profilepage.php
    $_SESSION['user_data'] = [
        'name' => $name,
        'about_me' => $userData['about_me'],
        'profile_pic_src' => $profilePicSrc
    ];
} else {
    // If user data not found, redirect or show an error
    $_SESSION['status'] = "Invalid user";
    header('Location: homepage.php');
    exit;
}

// Fetch followings count
$followingsStmt = $con->prepare("SELECT COUNT(*) as followings_count FROM follows WHERE follower = ? AND verified = 1");
$followingsStmt->bind_param("s", $username);
$followingsStmt->execute();
$followingsResult = $followingsStmt->get_result();
$followingsCount = $followingsResult->fetch_assoc()['followings_count'];

// Fetch shared pictures count from the new table
$sharedPicturesStmt = $con->prepare("SELECT count FROM shared_pictures_count WHERE username = ?");
$sharedPicturesStmt->bind_param("s", $username);
$sharedPicturesStmt->execute();
$sharedPicturesResult = $sharedPicturesStmt->get_result();
$sharedPicturesCount = $sharedPicturesResult->fetch_assoc()['count'];

// Store the counts in session for use in profilepage.php
$_SESSION['followings_count'] = $followingsCount;
$_SESSION['shared_pictures_count'] = $sharedPicturesCount;

// Fetch pending follow requests
$followRequestsStmt = $con->prepare("SELECT follower FROM follows WHERE followed = ? AND verified = 0");
$followRequestsStmt->bind_param("s", $username);
$followRequestsStmt->execute();
$followRequestsResult = $followRequestsStmt->get_result();

$followRequests = [];
while ($row = $followRequestsResult->fetch_assoc()) {
    $followRequests[] = $row['follower'];
}
$_SESSION['follow_requests'] = $followRequests;
?>
