<?php
session_start();

$page_title = "Password Change Update";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>

    <!-- custom css -->
    <link rel="stylesheet" href="css/sign_up.css">


    <!-- FONT AWESOME CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
    <body>
        <div class="container">
            <div class="sign_up_container">
                <div class="titles">
                    <h1>PassWord Reset</h1>
                </div>
                <?php
                    if (isset($_SESSION['status'])) {
                        ?>
                        <style>
                            h4{
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
                <form action="password-reset-code.php" method="POST">
                <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
                
                        <!-- Email Input -->
                    <div class="input_details">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
    
                        <!-- PassWord -->
                    <div class="input_details">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="new_password" placeholder="Password" required>
                    </div>
    
                        <!-- Confirm PassWord -->
                    <div class="input_details">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                    <!-- Sign Up Button -->
                <div class="submit_button_container">
                    <button type="submit" name="password_update" class="btn btn-primary">Submit</button>
                </div>
                </form> 
  
            </div>

        </div>
    </body>