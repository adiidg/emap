<?php
session_start();

$page_title = "Password Reset Page";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

    <!-- custom css -->
    <link rel="stylesheet" href="css/resend&reset1.css">


    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="container">
        <div class="login_in_container">
            <div class="title">
                <h2>Verify Email</h2>
            </div>

            <?php
            if (isset($_SESSION['status'])) {
                ?>
                <style>
                    h4 {
                        color: #F09819;
                        padding: 10px;
                        border-radius: 5px;
                        background-color: transparent;
                        margin: 10px;
                    }
                </style>
                <div class="alert alert-success">
                    <h4><?= $_SESSION['status']; ?></h4>
                </div>
                <?php
                unset($_SESSION['status']);
            }
            ?>

            <form action="resend-code.php" method="POST">
                <!-- User Name -->
                <div class="input_details">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="email" placeholder="Email" required>
                </div>

                <div class="button_container">
                    <button type="submit" name="resend_email_verify_btn" class="btn btn-primary">Resend link</button>
                </div>
            </form>
        </div>
    </div>

</body>