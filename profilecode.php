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
if(isset($_POST["submit"])){ 
    if(!empty($_FILES["profile_picture"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["profile_picture"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            // Get the username from the session
            $username = $_SESSION['auth_user']['username'];

            // Check if a profile picture already exists for the user
            $stmt = $con->prepare("SELECT * FROM profile_pictures WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            // If profile picture exists, update it, otherwise insert a new one
            if($result->num_rows > 0) {
                $stmt = $con->prepare("UPDATE profile_pictures SET file_name = ?, file_type = ?, content = ?, created = NOW() WHERE username = ?");
                $stmt->bind_param("ssbs", $fileName, $fileType, $null, $username); 
            } else {
                $stmt = $con->prepare("INSERT INTO profile_pictures (username, file_name, file_type, content, created) VALUES (?, ?, ?, ?, NOW())");
                $stmt->bind_param("sssb", $username, $fileName, $fileType, $null); 
            }
            $stmt->send_long_data(2, file_get_contents($_FILES['profile_picture']['tmp_name'])); // Send the binary data

            if($stmt->execute()){ 
                $statusMsg = "Profile picture uploaded successfully."; 
            } else { 
                $statusMsg = "Profile picture upload failed, please try again. Error: " . $stmt->error; 
            }
        } else { 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    } else { 
        $statusMsg = 'Please select a profile picture to upload.'; 
    } 
} else {
    $statusMsg = 'Profile picture upload form is not submitted.';
}

// Display status message 
echo $statusMsg; 
?>
