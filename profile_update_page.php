<?php
include('dbcon.php');
include('profile_update.php');

// Check if user is logged in
if (!isset($_SESSION['authenticated'])) {
    header('Location: login.php');
    exit;
}

// Initialize error variable
$error = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Include the profile update logic
    include('profile_update.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>
<body>
    <h1>Update Profile</h1>
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_data']['name']); ?>">
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?>">
        
        <label for="about_me">About Me:</label>
        <textarea id="about_me" name="about_me"><?php echo htmlspecialchars($_SESSION['user_data']['about_me']); ?></textarea>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture">
        
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
