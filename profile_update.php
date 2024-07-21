<?php
// Include the database configuration file
require_once 'dbcon.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['authenticated'])) {
    echo "User is not logged in.";
    exit;
}

// Get the current username from session
$currentUsername = $_SESSION['auth_user']['username'];
$error = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $name = $_POST['name'];
    $newUsername = $_POST['username'];
    $about_me = $_POST['about_me'];

    // Check if the new username exists and is different from the current username
    if (!empty($newUsername) && $newUsername !== $currentUsername) {
        $stmt = $con->prepare("SELECT username FROM users WHERE username = ?");
        $stmt->bind_param("s", $newUsername);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username already exists.";
        }
    }

    if (empty($error)) {
        // Prepare the update query
        $updateQuery = "UPDATE users SET ";
        $updateFields = [];
        $paramValues = [];

        // Check and add fields to the update query if they are not empty
        if (!empty($name)) {
            $updateFields[] = "name = ?";
            $paramValues[] = $name;
        }
        if (!empty($newUsername)) {
            $updateFields[] = "username = ?";
            $paramValues[] = $newUsername;
        }
        if (!empty($about_me)) {
            $updateFields[] = "about_me = ?";
            $paramValues[] = $about_me;
        }

        // If there are fields to update
        if (!empty($updateFields)) {
            // Construct the SET clause of the update query
            $updateQuery .= implode(", ", $updateFields);
            $updateQuery .= " WHERE username = ?";
            $paramValues[] = $currentUsername;

            // Prepare and bind parameters for the update query
            $stmt = $con->prepare($updateQuery);

            // Initialize the parameter array with corresponding types
            $paramTypes = str_repeat("s", count($paramValues));

            // Bind parameters dynamically
            $stmt->bind_param($paramTypes, ...$paramValues);

            // Execute the update query
            if ($stmt->execute()) {
                // If update is successful, update session data
                if (!empty($name)) {
                    $_SESSION['user_data']['name'] = $name;
                }
                if (!empty($newUsername)) {
                    $_SESSION['user_data']['username'] = $newUsername;
                    $_SESSION['auth_user']['username'] = $newUsername;
                }
                if (!empty($about_me)) {
                    $_SESSION['user_data']['about_me'] = $about_me;
                }

                // Check if profile picture is uploaded
                if (!empty($_FILES["profile_picture"]["name"])) {
                    // Get file info
                    $fileName = basename($_FILES["profile_picture"]["name"]);
                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

                    // Allow certain file formats
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($fileType, $allowTypes)) {
                        // Update the profile picture record
                        $profilePicContent = file_get_contents($_FILES['profile_picture']['tmp_name']);

                        // Check if a record exists for the user in profile_pictures table
                        $stmt = $con->prepare("SELECT username FROM profile_pictures WHERE username = ?");
                        $stmt->bind_param("s", $currentUsername);
                        $stmt->execute();
                        $stmt->store_result();

                        if ($stmt->num_rows > 0) {
                            // If record exists, update it
                            $stmt = $con->prepare("UPDATE profile_pictures SET file_name = ?, file_type = ?, content = ?, created = NOW() WHERE username = ?");
                            $stmt->bind_param("ssss", $fileName, $fileType, $profilePicContent, $newUsername);
                        } else {
                            // If record does not exist, insert a new one
                            $stmt = $con->prepare("INSERT INTO profile_pictures (username, file_name, file_type, content, created) VALUES (?, ?, ?, ?, NOW())");
                            $stmt->bind_param("ssss", $newUsername, $fileName, $fileType, $profilePicContent);
                        }

                        $stmt->execute();
                    } else {
                        echo 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
                    }
                }

                // Update username in other tables if it has changed
                if ($newUsername && $newUsername !== $currentUsername) {
                    $stmt = $con->prepare("UPDATE media SET username = ? WHERE username = ?");
                    $stmt->bind_param("ss", $newUsername, $currentUsername);
                    $stmt->execute();

                    $stmt = $con->prepare("UPDATE profile_pictures SET username = ? WHERE username = ?");
                    $stmt->bind_param("ss", $newUsername, $currentUsername);
                    $stmt->execute();

                    $stmt = $con->prepare("UPDATE users SET username = ? WHERE username = ?");
                    $stmt->bind_param("ss", $newUsername, $currentUsername);
                    $stmt->execute();
                }

                // Redirect to profile page or any other page
                header("Location: profilepage.php");
                exit;
            } else {
                // If update fails, display error message
                echo "Error updating user data.";
                exit;
            }
        } else {
            // If no fields are provided for update, display error message
            echo "No fields provided for update.";
            exit;
        }
    }
}
?>
