<?php
require("a1.html");
require("conn.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background: linear-gradient(45deg, #6ab1d7, #33d9b2);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background: white;
      padding: 20px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="password"],
    input[type="tel"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="tel"]:focus {
      border-color: #33d9b2;
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      background: #33d9b2;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #28a745;
    }

    .captcha {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .captcha img {
      height: 40px;
      border-radius: 5px;
    }

    .otp-group {
      display: flex;
      justify-content: space-between;
    }

    .otp-group input {
      width: 18%;
      text-align: center;
    }

    .container {
      width: 300px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .captcha-container {
      display: flex;
      align-items: center;
      margin-bottom: 18px;
    }

    #captchaText {
      flex: 1;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-right: 10px;
    }

    .captcha-icon {
      font-size: 24px;
      color: black;
      cursor: pointer;
    }

    input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: white;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .cap1 {
      background-image: url('back_cap.jpg');
      color: white;
      /* Text color */
      font-size: 18px;
      font-weight: bolder;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Forgot Password</h2>
    <form method="post" id="forgotPasswordForm">
      <div class="form-group">
        <label for="userId">User ID</label>
        <input type="text" id="userId" name="id" required>
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="number" id="phone" name="phone" required>
      </div>
      <div class="form-group captcha-container">
        <input type="text" class="cap1" name="t1" id="captchaText" readonly>
        <button type="button" onclick="generateCaptcha()"><i class="fa-solid fa-rotate-right captcha-icon"></i></button>
      </div>
      <div class="form-group captcha">
        <input type="text" placeholder="Write Above Captcha" id="captcha" name="captcha" required>
      </div>
      <div class="form-group captcha">
        <input type="password" placeholder="Create New Password" id="captcha" name="pass" required>
      </div>
      <button type="submit" class="btn" name="sub">Submit</button>
    </form>
  </div>
</body>

</html>
<script>
  function generateCaptcha() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&0123456789abcdefghijklmnopqrstuvwxyz';
    let captcha = '';
    for (let i = 0; i < 6; i++) {
      captcha += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('captchaText').value = captcha;
  }
  document.addEventListener('DOMContentLoaded', generateCaptcha);
</script>

<?php
if (isset($_POST["sub"])) {
    $id = $_POST["id"];
    $phone = $_POST["phone"];
    $admin_cap = $_POST["t1"];
    $user_cap = $_POST["captcha"];
    $pass = $_POST["pass"];

    $record = mysqli_query($conn, "SELECT * FROM `sign_up` WHERE `phone` = '$phone' AND `user_id` = '$id'");
    $row = mysqli_num_rows($record);
    if ($row > 0) {
        if ($admin_cap == $user_cap) {
            $update = mysqli_query($conn, "UPDATE `sign_up` SET `password`='$pass' WHERE `user_id` = '$id'");
            if ($update) {
                echo "<script>
                
                    Swal.fire({
                        title: 'Password Updated!',
                        text: 'Your password has been successfully updated.',
                        icon: 'success',
                    }).then(function() {
                        setTimeout(function() {
                            window.location = 'index.php';
                        }, 100);
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Internal Error!',
                        text: 'Please try again later.',
                        icon: 'error'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Invalid Captcha!',
                    text: 'Please enter a valid captcha.',
                    icon: 'error'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'User Not Found!',
                text: 'Please enter valid information.',
                icon: 'error'
            });
        </script>";
    }
}
?>
