<?php

session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function send_password_reset($get_email, $token){
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "vibechatt@gmail.com";
    $mail->Password = "ijyilutyljrgqrwj"; 
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->setFrom("vibechatt@gmail.com");
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject = "Reset Password for VibeChat";
    $email_template = "
    <h2>You have received this email to reset your password</h2>
    <h3>change password through given linkk</h3>
    <a href='http://localhost/vc/v1/password-change.php?token=$token&email=$get_email'> Click Me </a>
    ";
    $mail->Body = $email_template;

    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }
}

if (isset($_POST['password_reset_link'])) {

  $email = mysqli_real_escape_string($con, $_POST['email']);
  $token = md5(rand());

  $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
  $check_email_run = mysqli_query($con, $check_email_query);

  if (mysqli_num_rows($check_email_run) > 0) {
    $row = mysqli_fetch_array($check_email_run);
    $get_email = $row['email'];

    $update_token_query = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
    $update_token_run = mysqli_query($con, $update_token_query);

    if ($update_token_run) {
        send_password_reset($get_email, $token);

        $_SESSION['status'] = "We e-mailed you a password reset link";
        header("Location: password-reset.php");
        exit(0);
    } else {
        $_SESSION['status'] = "An error occurred while processing your request. Please try again later.";
        header("Location: password-reset.php");
        exit(0);
    }
  } else {
    $_SESSION['status'] = "No Email Found";
    header("Location: password-reset.php");
    exit(0);
  }
}

if (isset($_POST['password_update'])) {

  $email = mysqli_real_escape_string($con, $_POST['email']);
  $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
  $token = mysqli_real_escape_string($con, $_POST['password_token']);

  if (!empty($_POST['password_token'])) {
    

    if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
        
            $check_token_query = "SELECT verify_token FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token_query);

            if (mysqli_num_rows($check_token_run) > 0) {
                if($new_password == $confirm_password){
                    $update_password = "UPDATE users SET password='$new_password' WHERE verify_token='$token' LIMIT 1"; 
                    $update_password_run = mysqli_query($con, $update_password);

                    if($update_password_run){
                        $new_token=md5(rand());
                        $update_to_new_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' LIMIT 1"; 
                        $update_to_new_token_run = mysqli_query($con, $update_to_new_token);

                        $_SESSION['status'] = "New password succesfully updated"; 
                        header("Location: login.php");
                        exit(0);
                    }else{
                        $_SESSION['status'] = "did not update password something went wrong"; 
                        header("Location: password-change.php?token=$token&email=$email");
                        exit(0);
                    }
                }else{
                    $_SESSION['status'] = "Password and Confirm Password does not match"; 
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0);
                }

            } else {
              $_SESSION['status'] = "Invalid Token";
              header("Location: password-change.php?token=$token&email=$email");
              exit(0);
            }

    } else {
      $_SESSION['status'] = "All Fields are Mandatory";
      header("Location: password-change.php?token=$token&email=$email");
      exit(0);
    }
  } else {
    $_SESSION['status'] = "No Token Available";
    header("Location: password-change.php");
    exit(0);
  }
}


?>