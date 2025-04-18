<?php
 require("a1.html");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Sign Up</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        body {
            background: url('sign_up.gif') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .signup-container {
            position: relative;
            z-index: 1;
            background-color: transparent;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin: auto;
            top: 50%;
            transform: translateY(-50%);
        }
        .signup-container:hover {
            transition: 0.5s ease-in-out;
            box-shadow: 0 0 40px white;
        }
        .signup-container h2 {
            margin-bottom: 20px;
            color: white;
        }

        .signup-container label {
            display: block;
            margin-bottom: 5px;
            text-align: left;
            color: white;
        }

        .signup-container input[type="text"],
        .signup-container input[type="number"],
        .signup-container input[type="email"],
        .signup-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333;
        }

        .signup-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .signup-container button:hover {
            background-color: #0056b3;
        }
        .a1 {
            color: white;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            color: white;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form method="POST">
            <label for="name"><i class="fa-solid fa-user"></i> Name</label>
            <input type="text" id="name" name="name" required>
            
            <label for="phone"><i class="fa-solid fa-phone"></i> Phone Number</label>
            <input type="number" id="phone" name="phone" pattern="[0-9]{10}" required>
            
            <label for="userid"><i class="fa-solid fa-envelope"></i> Valid Email</label>
            <input type="email" id="userid" name="email" required>

            <label for="userid"><i class="fa-solid fa-id-badge"></i> Create User ID</label>
            <input type="text" id="userid" name="userid" required>
            
            <label for="password"><i class="fa-solid fa-lock"></i> Create Password</label>
            <input type="password" id="password" name="password" required>

            <label for="password"><i class="fa-solid fa-lock"></i> Confirm Password</label>
            <input type="password" id="password1" name="password1" required>
            
            <button name="sign_up" type="submit">Sign Up</button>
            

           <div class="a1"><br> Already Have An Account ? <a href="index.php">Login</a></div>
        </form>
    </div>
</body>
</html>

<?php

require("conn.php");

if(isset($_POST["sign_up"])){
    $nm = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $id = $_POST["userid"];
    $pass = $_POST["password"];
    $c_pass = $_POST["password1"];
    $phone1 = strlen($phone);

    if($phone1 == 10){
        if($pass == $c_pass){
            $store = mysqli_query($conn, "INSERT INTO `sign_up`(`name`, `phone`,`email`, `user_id`, `password`) VALUES ('$nm','$phone','$email','$id','$pass')");
            if($store){
                echo "<script>
                    swal({
                        title: 'Sign Up Successful!',
                        text: 'You have been successfully registered.',
                        icon: 'success',
                    }).then(function() {
                        window.location = 'index.php';
                    });
                </script>";
            } else {
                echo "<script>
                    swal({
                        title: 'Error!',
                        text: 'There was an error while signing up. Please try again.',
                        icon: 'error',
                    });
                </script>";
            }
        } else {
            echo "<script>
                swal({
                    title: 'Password Not Matched!',
                    text: 'Please ensure the passwords match.',
                    icon: 'warning',
                });
            </script>";
        }
    } else {
        echo "<script>
            swal({
                title: 'Invalid Phone Number!',
                text: 'Please enter a valid 10-digit phone number.',
                icon: 'warning',
            });
        </script>";
    }
}
?>
