<?php
include ('dbcon.php');
include ('profile_get.php');

// Retrieve user data from session
$userData = $_SESSION['user_data'];
$followingsCount = $_SESSION['followings_count'];
$sharedPicturesCount = $_SESSION['shared_pictures_count'];
$followRequests = $_SESSION['follow_requests'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My VibeChat Profile</title>

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- custom cdn -->
    <link rel="stylesheet" href="css/profilepage.css">
</head>

<body>
    <div class="container">

        <!-- Tile Container -->
        <nav>
            <div class="menu_container">
                <button><i class="ri-arrow-left-s-line"></i></button>
                <button class="open_sidebar"><i class="ri-menu-line"></i></button>
            </div>
        </nav>

        <!-- SideBar -->
        <div class="sidebar_container">
            <div class="close_button_container">
                <button class="close_sidebar"><i class="ri-close-large-line"></i></button>
                <h2>Setting</h2>
            </div>
            <div class="sidebar_options">
                <ul>
                    <li><a href="profile_update_page.php"><button><i></i>
                                <h3>Edit Profile</h3>
                            </button></a></li>

                </ul>
            </div>
            <div class="logo_out_container">
                <a href="logout.php">
                    <h3>Log Out</h3>
                </a>
            </div>
        </div>

        <!-- Edit Profile -->
        <div class="edit_profile_container">
            <div class="edit_profile_title_container">
                <div class="edit_profile_left_container">
                    <button class="edit_profile_close_sidebar"><i class="ri-close-large-line"></i></button>
                    <h2>Edit Profile</h2>
                </div>
                <button id="edit_profile_close_button">Done</button>
            </div>
            <div class="edit_profile_main_container">
                <div class="edit_profile_outer_image_container">
                    <div class="edit_profile_inner_image_container">
                        <img src="<?php echo $userData['profile_pic_src']; ?>" alt="Profile Picture">
                    </div>
                </div>
            </div>
            <div class="form_container">
                <form action="">
                    <div class="edit_profile_input_container">
                        <h3>Name</h3>
                        <input type="text" placeholder="Name" required
                            value="<?php echo htmlspecialchars($userData['name']); ?>">
                    </div>
                    <div class="edit_profile_input_container">
                        <h3>UserName</h3>
                        <input type="text" placeholder="UserName" required
                            value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <div class="edit_profile_input_container">
                        <h3>About Me</h3>
                        <textarea><?php echo htmlspecialchars($userData['about_me']); ?></textarea>
                    </div>
                </form>
            </div>
        </div>

        <!-- Profile Image -->
        <div class="profile_image_container">
            <div class="image_container">
                <img src="<?php echo $userData['profile_pic_src']; ?>" alt="Profile Picture">
            </div>
        </div>

        <!-- Name and UserId -->
        <div class="name_username_container">
            <h2><?php echo htmlspecialchars($userData['name'] ?? 'Your Name'); ?></h2>
            <h4><?php echo htmlspecialchars($username); ?></h4>
        </div>

        <!-- Following Sections -->
        <div class="following_section">
            <button id="followingsButton">
                <h3>Credits</h3>
                <h2><?php echo $followingsCount; ?></h2>
            </button>
            <button>
                <h3>Share Stories</h3>
                <h2><?php echo $sharedPicturesCount; ?></h2>
            </button>
        </div>
        <!-- Modal for Followings List 
        <div id="followingsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Followings</h2>
                <ul id="followingsList"></ul>
            </div>
        </div>-->

        <div class="user_info_container">
            <h3>About Me</h3>
            <div class="about_me">
                <p><?php echo htmlspecialchars($userData['about_me']); ?></p>
            </div>
        </div>


        <!-- Bottom Space -->
        <div class="space_at_end"></div>


    </div>

    <script src="js/profilepage.js"></script>
</body>

</html>