<?php
session_start();

$page_title = "E waste Page";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>



    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- custom css -->
    <link rel="stylesheet" href="css/index1.css">
</head>

<body>
    <div class="container">
        <div class="sign_up_container">
            <div class="titles">
                <h1>World of E-waste</h1>
                <iframe width="560" height="315"
                    src="https://www.youtube.com/embed/ApdkhWd7SfQ?si=Cy1RkiLdWAeSajnx&amp;start=15"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <p class="heading_color">Our website helps users locate e-waste facility centers,
                    contact us for assistance, and learn about the importance of e-waste recycling to promote
                    sustainable practices.
                <p>
            </div>
            <div class="img_container">
                <img src="images/logoname.png" alt="">
            </div>
            <div class="submit_button_container">
                <a href="login.php">Login</a>
            </div>
            <div class="submit_button_container">
                <a href="register.php">Sign Up</a>
            </div>

        </div>

    </div>
</body>

</html>