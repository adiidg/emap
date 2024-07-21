<?php
include ('dbcon.php');
include ('user_get_timeline.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Media Gallery</title>
    <style>
        .gallery img,
        .gallery video {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .gallery video {
            display: block;
        }

        .posts_container {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 15px;
        }

        .post_title_container {
            display: flex;
            align-items: center;
        }

        .post_userimage img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .post_user_details h3,
        .post_user_details p {
            margin: 0;
        }

        .descrption_container {
            margin: 15px 0;
        }

        .main_post_image_container img,
        .main_post_image_container video {
            width: 100%;
            height: auto;
        }

        .comment_container {
            display: flex;
            justify-content: space-around;
        }

        .button_container button {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .button_container button p {
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <?php if ($result->num_rows > 0) { ?>
        <div class="gallery">
            <?php while ($row = $result->fetch_assoc()) {
                $fileType = $row['file_type'];
                $mediaContent = base64_encode($row['media']);
                $username = $row['username'];
                $name = $row['name'];
                $email = $row['email'];
                $created = $row['created'];
                $content = $row['content'];
                $no_of_likes = $row['no_of_likes'];
                $no_of_comments = $row['no_of_comments'];
                $profileFileType = $row['profile_file_type'];
                $profileContent = base64_encode($row['profile_content']);
                ?>
                <div class="posts_container">
                    <!-- card title part -->
                    <div class="post_title_container">
                        <div class="post_userimage">
                            <?php if ($profileFileType) { ?>
                                <img src="data:<?php echo $profileFileType; ?>;base64,<?php echo $profileContent; ?>" alt="">
                            <?php } else { ?>
                                <img src="default_profile_picture.jpg" alt="">
                            <?php } ?>
                        </div>
                        <div class="post_user_details">
                            <h3><?php echo $name; ?></h3>
                            <p><?php echo $username; ?></p>
                        </div>
                    </div>
                    <!-- Description Container -->
                    <div class="descrption_container">
                        <div class="content_holder">
                            <p><?php echo $content; ?></p>
                        </div>
                    </div>
                    <!-- card image part -->
                    <div class="main_post_image_container">
                        <?php if (strpos($fileType, 'image') !== false) { ?>
                            <img src="data:<?php echo $fileType; ?>;base64,<?php echo $mediaContent; ?>" />
                        <?php } elseif (strpos($fileType, 'video') !== false) { ?>
                            <video controls>
                                <source src="data:<?php echo $fileType; ?>;base64,<?php echo $mediaContent; ?>">
                                Your browser does not support the video tag.
                            </video>
                        <?php } ?>
                    </div>

                    <!-- comment section part -->
                    <div class="comment_container">
                        <div class="button_container">
                            <button>
                                <i class="ri-heart-3-line"></i>
                                <p>Like (<?php echo $no_of_likes; ?>)</p>
                            </button>
                            <button>
                                <i class="ri-chat-3-line"></i>
                                <p>Comment (<?php echo $no_of_comments; ?>)</p>
                            </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p class="status error">Media file(s) not found...</p>
    <?php } ?>
</body>

</html>