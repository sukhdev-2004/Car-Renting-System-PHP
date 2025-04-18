<?php
    require "a1.html";
    require "conn.php";
    session_start();

    if(isset($_POST["login"])) {
        $id = $_POST["username"];
        $pass = $_POST["password"];

        $query = "SELECT `name`, `phone`, `user_id`, `password` FROM `sign_up` WHERE `user_id` = '$id' AND `password` = '$pass'";
        $record = mysqli_query($conn, $query);
        $row = mysqli_num_rows($record);

        if($id == "YuvrajDabhi@2005" && $pass == "YuvraJ5252@#")
        {
            echo "<script>window.location.href = 'ty_admin_data/users_details.php';</script>";
        }
         else
         {
            if($row > 0) {
                $_SESSION['id'] = $id;
                echo "<script>window.location = 'home.php';</script>";
                exit;
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
         }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .bg-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .login-container {
            background: transparent;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: 0.5s ease-in-out;
            color: black;
        }
        .login-container:hover {
            transition: 0.5s ease-in-out;
            box-shadow: 0 0 30px black;
        }
        .login-container h2 {
            margin-bottom: 20px;
        }
        .input-container {
            position: relative;
            width: 90%;
            margin: 10px 0;
        }
        .input-container input {
            width: 90%;
            padding: 10px 10px 10px 40px;
            border: 1px solid black;
            border-radius: 5px;
        }
        .input-container .fa {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .login-container button {
            width: 97%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.5s ease-in-out;
        }
        .login-container button:hover {
            background-color: #45a049;
            transition: 0.5s ease-in-out;
            box-shadow: 0 0 20px black;
            border: 2px solid black;
        }
        .login-container a {
            text-decoration: none;
            color: #007BFF;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
        .forgot-password, .signup {
            margin-top: 10px;
        }
        .signup {
            margin-top: 20px;
        }
        h2{
            color:white;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video autoplay muted loop class="bg-video">
            <source src="login.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <div class="login-container">
        <h2>Car Rental Login</h2>
        <form method="post">
            <div class="input-container">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-container">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="forgot-password">
                <a href="forget.php">Forgot Password?</a>
            </div>
            <br>
            <button type="submit" name="login">Login</button>
            <div class="signup">
                No account? <a href="sign_up.php">Sign Up</a>
            </div>
        </form>
    </div>
</body>
</html>
