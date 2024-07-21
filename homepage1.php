<?php
include ('dbcon.php');
include ('get_timeline.php');
include ('user_get_timeline.php');

if (!isset($_SESSION['authenticated'])) {
    $_SESSION['status'] = "Please Login";
    header('Location: login.php');
    exit(0);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- custom cdn -->
    <link rel="stylesheet" href="css/homepage1.css">

</head>

<body>

    <div class="container">
        <!-- Title -->
        <div class="title_container">
            <div id="title_heading_container">
                <h3>TIMELINE</h3>
            </div>
            <div class="butun">
                <a href="post.php"><button class="home_search_button"><img class="svg_icon"
                            src="Svg_Files/camera_icon.svg"></button></a>
                <a href="profilepage.php"><button class="home_search_button"><img class="svg_icon"
                            src="Svg_Files/user_icon.svg"></button></a>
            </div>
        </div>

        <!-- Navigation Bar -->
        <nav>
            <div class="nav_container">
                <button class="following_btn">
                    <h3>All Timeline</h3>
                </button>
                <button class="my_snap_btn">
                    <h3>My Timeline</h3>
                </button>
                <div class="nav_sliding_line"></div>
            </div>
        </nav>

        <!-- Public Snaps -->
        <div class="feeds">
            <div class="feed_scrolling_container">
                <!-- Public posts dynamically generated -->
                <?php if (count($timelineData) > 0) { ?>
                    <?php foreach ($timelineData as $row) {
                        $mediaFileType = $row['media_file_type'];
                        $mediaContent = base64_encode($row['media']);
                        $profileFileType = $row['profile_file_type'];
                        $profileContent = $row['profile_content'] ? base64_encode($row['profile_content']) : null;
                        $file_name = $row['media_file_name'];
                        $username = $row['username'];
                        $name = $row['name'];
                        $email = $row['email'];
                        $content = $row['content'];
                        $noOfLikes = $row['no_of_likes'];
                        $noOfComments = $row['no_of_comments'];
                        ?>
                        <div class="posts_container">
                            <!-- post Title -->
                            <div class="post_title_container">
                                <div class="post_left_content">
                                    <div class="post_userimage">
                                        <?php
                                        if ($profileContent && $profileFileType) {
                                            // If profile picture content and type exist
                                            $profilePicSrc = 'data:' . $profileFileType . ';base64,' . $profileContent;
                                        } else {
                                            // If profile picture content or type do not exist, set default profile picture source
                                            $profilePicSrc = 'default/default.png';
                                        }
                                        ?>
                                        <img src="<?php echo $profilePicSrc; ?>" alt="Profile Picture">
                                    </div>
                                    <div class="post_user_details">
                                        <h3><?php echo htmlspecialchars($name); ?></h3>
                                        <a
                                            href="others_profilepage.php?username=<?php echo htmlspecialchars($username); ?>"><?php echo htmlspecialchars($username); ?></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Title -->
                            <div class="descrption_container">
                                <div class="content_holder">
                                    <p><?php echo htmlspecialchars($content); ?></p>
                                </div>
                            </div>

                            <!-- main Post -->
                            <div class="main_post_image_container">
                                <div class="media_container">
                                    <?php if (strpos($mediaFileType, 'image') !== false) { ?>
                                        <img src="data:<?php echo $mediaFileType; ?>;base64,<?php echo $mediaContent; ?>">
                                    <?php } elseif (strpos($mediaFileType, 'video') !== false) { ?>
                                        <video class="video" controls>
                                            <source src="data:<?php echo $mediaFileType; ?>;base64,<?php echo $mediaContent; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                        <button class="play_pause_button"><i class="ri-play-fill"></i></button>
                                        <div class="custom_controls">
                                            <input type="range" class="progressBar" value="0">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Comment Section 
                            <div class="comment_container">
                                <div class="holder">
                                    <button><img class="svg_icon" src="Svg_Files/heart_icon.svg"></button>
                                    <span class="count"><?php echo $row['no_of_likes']; ?></span>
                                </div>

                                <div class="holder comment_holder">
                                    <button><img class="svg_icon" src="Svg_Files/chat_icon.svg"></button>
                                    <span class="count"><?php echo $row['no_of_comments']; ?></span>
                                </div>
                            </div>-->


                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="status error">Media file(s) not found...</p>
                <?php } ?>


            </div>
        </div>

        <!-- Private Snaps -->
        <div class="my_snap_container">
            <div class="my_feed_scrolling_container">
                <!-- Private posts dynamically generated -->
                <?php if (count($user_timelineData) > 0) { ?>
                    <?php foreach ($user_timelineData as $row) {
                        $mediaFileType = $row['media_file_type'];
                        $mediaContent = base64_encode($row['media']);
                        $profileFileType = $row['profile_file_type'];
                        $profileContent = $row['profile_content'] ? base64_encode($row['profile_content']) : null;
                        $file_name = $row['media_file_name'];
                        $username = $row['username'];
                        $name = $row['name'];
                        $email = $row['email'];
                        $content = $row['content'];
                        $noOfLikes = $row['no_of_likes'];
                        $noOfComments = $row['no_of_comments'];
                        ?>
                        <div class="posts_container">
                            <!-- post Title -->
                            <div class="post_title_container">
                                <div class="post_left_content">
                                    <div class="post_userimage">
                                        <?php
                                        if ($profileContent && $profileFileType) {
                                            // If profile picture content and type exist
                                            $profilePicSrc = 'data:' . $profileFileType . ';base64,' . $profileContent;
                                        } else {
                                            // If profile picture content or type do not exist, set default profile picture source
                                            $profilePicSrc = 'default/default.png';
                                        }
                                        ?>
                                        <img src="<?php echo $profilePicSrc; ?>" alt="Profile Picture">
                                    </div>
                                    <div class="post_user_details">
                                        <h3><?php echo htmlspecialchars($name); ?></h3>
                                        <a
                                            href="others_profilepage.php?username=<?php echo htmlspecialchars($username); ?>"><?php echo htmlspecialchars($username); ?></a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description Title -->
                            <div class="descrption_container">
                                <div class="content_holder">
                                    <p><?php echo htmlspecialchars($content); ?></p>
                                </div>
                            </div>

                            <!-- main Post -->
                            <div class="main_post_image_container">
                                <div class="media_container">
                                    <?php if (strpos($mediaFileType, 'image') !== false) { ?>
                                        <img src="data:<?php echo $mediaFileType; ?>;base64,<?php echo $mediaContent; ?>">
                                    <?php } elseif (strpos($mediaFileType, 'video') !== false) { ?>
                                        <video class="video" controls>
                                            <source src="data:<?php echo $mediaFileType; ?>;base64,<?php echo $mediaContent; ?>">
                                            Your browser does not support the video tag.
                                        </video>
                                        <button class="play_pause_button"><i class="ri-play-fill"></i></button>
                                        <div class="custom_controls">
                                            <input type="range" class="progressBar" value="0">
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Comment Section 
                            <div class="comment_container">
                                <div class="holder">
                                    <button><img class="svg_icon" src="Svg_Files/heart_icon.svg"></button>
                                    <span class="count"><?php echo $row['no_of_likes']; ?></span>
                                </div>

                                <div class="holder comment_holder">
                                    <button><img class="svg_icon" src="Svg_Files/chat_icon.svg"></button>
                                    <span class="count"><?php echo $row['no_of_comments']; ?></span>
                                </div>
                            </div>-->

                            <!-- Delete Post -->
                            <form action='delete_post.php' method='POST'
                                onsubmit='return confirm("Are you sure you want to delete this post?");'>
                                <input type='hidden' name='file_name' value='<?php echo $row['media_file_name']; ?>'>
                                <button type='submit'>Delete Post</button>
                            </form>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="status error">Media file(s) not found...</p>
                <?php } ?>
            </div>
        </div>




        <!-- Comment Container -->
        <div class="sliding_comment_container">

            <div class="secondary_comment_cotainer">
                <!-- Fixed Title -->
                <div class="comment_title">
                    <button><img class="svg_icon" src="Svg_Files/arrowleft_icon.svg" alt=""></button>
                    <h3>Comments</h3>
                </div>

                <!-- Comment Content -->
                <div class="comment_content">

                    <!-- comment wrapper -->
                    <div class="comment_wrapper">
                        <div class="comment_wrapper_title">
                            <div class="comment_left_container">
                                <div class="image_container"><img src="Test_Images/post8.jpeg"></div>
                                <div class="comment_details">
                                    <li>
                                        <h3>aditya_gurav</h3>
                                    </li>
                                    <p>3 days ago</p>
                                </div>
                            </div>

                            <div class="comment_right_container">
                                <img class="svg_icon" src="Svg_Files/ellipsis_vertical_icon.svg">
                            </div>
                        </div>

                        <div class="comment_text">
                            <p>Lorem ipsum dolor sit amet consectetur adi=pisicing elit. Corporis omnis doloribus quidem
                                magni consectetur ab asperiores doloremque debitis distinctio placeat magnam molestias
                                fugit animi quia quam obcaecati veritatis quos, perferendis hic? Harum earum quaerat
                                quasi asperiores autem quo delectus! Necessitatibus?</p>
                        </div>

                        <div class="comment_button">
                            <button><img class="svg_icon" src="Svg_Files/thumbup_icon.svg"></button>
                            <button><img class="svg_icon" src="Svg_Files/thumbdown_icon.svg"></button>
                            <button><img class="svg_icon" src="Svg_Files/comment_icon.svg"></button>
                            <button><img class="svg_icon" src="Svg_Files/share_icon.svg"></button>
                        </div>
                    </div>

                    <!-- Comment Wrapper Ends -->
                </div>

                <!-- Input Field -->
                <div class="input_container">
                    <input type="text" placeholder="Type Comment Here">
                    <button><img class="svg_icon" src="Svg_Files/arrowup_icon.svg"></button>
                </div>
            </div>
        </div>

    </div>
    <!-- Custom JavaScript -->
    <script src="js/homepage.js"></script>
</body>

</html>