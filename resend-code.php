<?php

session_start();
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



function resend_email_verify($email,$verify_token){
   

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
    $mail->Subject = "Resend Email Verification from VibeChat";
    $email_template = "
    <h2>You have Registered with VibeChat</h2>
    <h3>Verify your email address to Login with the below given link</h3>
    <a href='http://localhost/vc/v1/verify-email.php?token=$verify_token'> Click Me </a>
    ";
    $mail->Body = $email_template;

    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Error sending email: ' . $mail->ErrorInfo;
    }
}

if (isset($_POST['resend_email_verify_btn'])) {

  if (!empty(trim($_POST['email']))) {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $checkemail_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $checkemail_query_run = mysqli_query($con, $checkemail_query);
    if(mysqli_num_rows($checkemail_query_run) > 0){
        $row = mysqli_fetch_array($checkemail_query_run);
        if($row['verify_status'] == 0){
            $email=$row['email'];
            $verify_token=$row['verify_token'];

            resend_email_verify($email,$verify_token);
            $_SESSION['status'] = "Verification Email Link has been sent to your email address"; 
            header("Location: resend-email-verification.php");
            exit(0);
        }else{
            $_SESSION['status'] = "Email already verified. Please Login"; 
            header("Location: resend-email-verification.php");
            exit(0);
        }
    }else{
        $_SESSION['status'] = "Email is not registered. Please Register now.!"; 
        header("Location: register.php"); 
        exit(0);
    }
  }else{
    $_SESSION['status'] = "Please enter the email field";
    header("Location: resend-email-verification.php");
    exit(0);
  }
}

?>