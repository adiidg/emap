<?php
session_start();
include('dbcon.php');

if(isset($_POST['login_now_btn'])){
    if(!empty(trim($_POST['username'])) && !empty(trim($_POST['password']))){
        $username = mysqli_real_escape_string($con,$_POST['username']);
        $password = mysqli_real_escape_string($con,$_POST['password']);

        $login_query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1"; 
        $login_query_run = mysqli_query($con, $login_query);
        if(mysqli_num_rows($login_query_run) > 0){
            $row = mysqli_fetch_array($login_query_run);
            if($row['verify_status'] == "1")
            {
                $_SESSION['authenticated'] = TRUE;
                $_SESSION['auth_user'] = [
                    'username'=> $row['username']
                ];
                $_SESSION['username'] = $row['username'];
                $_SESSION['status'] = "You are logged in succesfully."; 
                header("Location: homepage.php"); 
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "Please Verify your Email Address to Login."; 
                header("Location: login.php"); 
                exit(0);
            }
        }
        else
        {
            
        }
$_SESSION['status'] = "Invalid Username or Password"; header("Location: login.php");
exit(0);
    }else{
        $_SESSION['status']="All fields are Mandatory";
        header("Location: login.php");
        exit(0);
    }
}

?>