<?php
session_start();
include('dbcon.php');

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status, username FROM users WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($con, $verify_query);

    if (mysqli_num_rows($verify_query_run) > 0) {
        $row = mysqli_fetch_array($verify_query_run);
        if ($row['verify_status'] == 0) {
            $clicked_token = $row['verify_token'];
            $username = $row['username'];
            $update_query = "UPDATE users SET verify_status=1 WHERE verify_token='$clicked_token' LIMIT 1";
            $update_query_run = mysqli_query($con, $update_query);

            if ($update_query_run) {
                // Insert the new record into the shared_pictures_count table
                $insert_query = "INSERT INTO shared_pictures_count (username, count) VALUES ('$username', 0)";
                $insert_query_run = mysqli_query($con, $insert_query);

                if ($insert_query_run) {
                    $_SESSION['status'] = "Your Account has been verified Successfully !!";
                } else {
                    $_SESSION['status'] = "Verification succeeded but failed to initialize shared pictures count.";
                }
                header("Location: login.php");
                exit(0);
            } else {
                $_SESSION['status'] = "Verification Failed !!";
                header("Location: login.php");
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Email Already Verified. Please Login";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['status'] = "This Token does not Exist";
        header("Location: login.php");
        exit(0);
    }
} else {
    $_SESSION['status'] = "Not Allowed";
    header("Location: login.php");
    exit(0);
}
?>
