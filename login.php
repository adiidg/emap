<?php
session_start();
if (isset($_SESSION['authenticated'])) {
    header('Location: homepage.php');
    exit(0);
}

$page_title = "Login Page";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>



    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- custom css -->
    <link rel="stylesheet" href="css/login1.css">

</head>

<body>
    <div class="container">
        <div class="login_in_container">
            <div class="title">
                <h1>Welcome Back</h1>
                <p>Enter Your Credential to Login</p>
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

            <form action="logincode.php" method="POST">
                <!-- User Name -->
                <div class="input_details">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Username" required>

                </div>

                <!-- Password Input -->
                <div class="input_details">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="button_container">
                    <button type="submit" name="login_now_btn" class="btn btn-primary">LogIn</button>
                </div>
            </form>

            <!-- forgot password -->
            <div class="forgot_password">
                <a href="password-reset.php">Forgot Password?</a>
            </div>
            <div class="forgot_password">
                <a href="resend-email-verification.php">Resend Verification Code?</a>
            </div>


            <!-- Create new Account -->
            <div class="new_account">
                <p>Don't have an account?</p>
                <a href="register.php">Sign Up</a>
            </div>

        </div>
    </div>

</body>