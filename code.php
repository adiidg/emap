<?php
session_start();
include ('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



function sendemail_verify($email, $verify_token)
{

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->Username = "vibechatt@gmail.com";
    $mail->Password = "ijyilutyljrgqrwj";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->setFrom("vibechatt@gmail.com");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Email Verification from VibeChat";
    $email_template = "
    <h2>VibeChat</h2>
    <h4>Verify your email address</h4>
    <a href='http://192.168.13.120/vc/vi/verify-email.php?token=$verify_token'> Click Me </a><br><br><br>
    <a href='http://192.168.13.120/vc/vi/profile_update_page.php'> update profile </a>
    ";
    $mail->Body = $email_template;

    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }
}

if (isset($_POST['register_btn'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verify_token = md5(rand());


    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);
    if (mysqli_num_rows($check_email_query_run) > 0) {
        $_SESSION['status'] = "Email Id already Exists please login";
        header("Location: login.php");
    } else {
        $check_username_query = "SELECT username FROM users WHERE username='$username' LIMIT 1";
        $check_username_query_run = mysqli_query($con, $check_username_query);
        if (mysqli_num_rows($check_username_query_run) > 0) {
            $_SESSION['status'] = "Username already Exists, try another one";
            header("Location: register.php");
        } else {

            if ($password == $confirm_password) {
                $query = "INSERT INTO users (email, username, password, verify_token) VALUES ('$email','$username','$password','$verify_token')";
                $query_run = mysqli_query($con, $query);
                if ($query_run) {
                    sendemail_verify($email, $verify_token);

                    $_SESSION['status'] = "Verification link sent, PLEASE CHECK SPAM/TRASH MAIL ALSO !!";
                    header("Location: register.php");
                } else {
                    $_SESSION['status'] = "Registration Failed";
                    header("Location: register.php");
                }
            } else {
                $_SESSION['status'] = "Password and Confirm Password does not match";
                header("Location: register.php");
                exit(0);
            }
        }
    }
}
