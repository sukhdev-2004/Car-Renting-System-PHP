<?php
session_start();
$user_id = $_SESSION['id'];
session_abort();
require("nav.php");

// Fetch user information from the database
$info = mysqli_query($conn, "SELECT * FROM `sign_up` WHERE `user_id` = '$user_id'");
$fetch = mysqli_fetch_assoc($info);
$nm = $fetch['name'];
$id = $fetch['user_id'];
$phone = $fetch['phone'];
$email = $fetch['email'];
$profile_picture = $fetch['profile'];

// Handle the form submission for updating user information
if (isset($_POST["update"])) {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $profilePicture = $profile_picture; // Default to existing profile picture

    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['size'] > 0) {
        $profilePicture = basename($_FILES['profilePicture']['name']);
        $target_dir = "profile/"; 
        $target_file = $target_dir . $profilePicture;

        if (!move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            echo "<script>alert('Failed to upload profile picture.');</script>";
            $profilePicture = $profile_picture; // Revert to existing profile picture if upload fails
        }
    }

    $sql = "UPDATE `sign_up` SET `name`='$name', `email`='$email', `phone`='$phone', `profile`='$profilePicture' WHERE `user_id`='$user_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Updated Successfully!');</script>";
        echo "<script>window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Dabhi Car Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }
        header h1 {
            margin: 0;
            font-size: 2.5em;
            color: #333;
        }
        .profile {
            padding: 20px 0;
        }
        .profile-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
            position: relative;
        }
        .profile-header .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-header h2 {
            margin: 10px 0 5px;
            font-size: 2em;
            color: #333;
        }
        .profile-header p {
            margin: 0;
            font-size: 1em;
            color: #666;
        }
        .profile-details,
        .profile-contact {
            margin: 50px 0;
        }
        .profile-details h3,
        .profile-contact h3 {
            font-size: 1.5em;
            color: #444;
            margin-bottom: 10px;
        }
        .profile-details p,
        .profile-contact p {
            font-size: 1em;
            color: #666;
            line-height: 1.6;
            margin: 5px 0;
        }
        .profile-details p strong,
        .profile-contact p strong {
            color: #333;
        }
        footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #eaeaea;
            margin-top: 20px;
        }
        footer p {
            margin: 0;
            font-size: 0.9em;
            color: #999;
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        #editBtn {
            position: absolute;
            right: 20px;
            top: 0;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 240px;
            margin-right: 350px;
        }
        #editBtn:hover {
            background-color: #0056b3;
        }
        .booking {
            margin: 50px 0;
        }
        .booking-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #eaeaea;
            border-radius: 5px;
            background-color: #fafafa;
        }
        .booking-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 20px;
        }
        .booking-item p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }
        .booking-item p strong {
            color: #333;
        }
        .canbtn {
            margin-top: 10px;
            background-color: black;
            color: white;
            padding: 10px;
            border-radius: 30px;
            transition: 0.2s ease-in-out;
        }
        .canbtn:hover {
            transition: 0.2s ease-in-out;
            background-color: red;
            box-shadow: 0 0 10px red;
            border: none;
        }
        .booking-item:hover {
            transition: 0.2s ease-in-out;
            box-shadow: 0 0 10px #333;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Dabhi Car Rental</h1>
    </header>
    <section class="profile">
        <div class="profile-header">
            <?php
            $profile_len = strlen($profile_picture);
            if($profile_len <= 0){
                $profile_picture = "p_demo1.png";
            }
            ?>
        <img src="profile/<?php echo $profile_picture; ?>" alt="User Profile Picture" class="profile-picture">
            <button id="editBtn">Edit</button>
            <h2><?php echo $nm; ?></h2>
            <p><?php echo $id; ?></p>
        </div>
        <div class="profile-details">
            <h3>Basic Information</h3>
            <p><strong>Full Name :</strong> <?php echo $nm; ?></p>
            <p><strong>Email :</strong> <?php echo $email; ?></p>
            <p><strong>Phone :</strong> <?php echo "+91 " . $phone; ?></p>
        </div>
        <div class="profile-contact">
            <h3>Contact Information</h3>
            <p><strong>Email :</strong> dabhiyuvraj1204@gmail.com</p>
            <p><strong>Contact Hours :</strong> 9:00 AM - 6:00 PM (Mon-Fri)</p>
            <p><strong>Address : </strong>B/32 Shreeji Complex, Nana Varacha, Surat 395006 </p>
        </div>
        <div class="booking">
            <h1>Your Car Booked By Customers</h1>
            <form method="post">
                <?php
                    $rental_data = mysqli_query($conn,"SELECT * FROM `book_car` WHERE `rental_id` = '$user_id' AND `status` = 'Pending'");
                    $tot_rental = mysqli_num_rows($rental_data);

                    // $user_data = mysqli_query($conn,"SELECT * FROM `book_car` WHERE `uid` = ''");
                    // echo "<script>alert('$tot_rental');</script>";
                    if($tot_rental > 0){
                        while($row = mysqli_fetch_assoc($rental_data)){
                            $rental_id = $row['rental_id'];
                                $car_image = $row['img'];
        
                                echo "
                                <div class='booking-item'>
                                    <img src='rent/$car_image' alt='Car Image' class='car-image'>
                                    <div>
                                         <p><strong>User Id:</strong> " . $row['uid'] . "</p>
                                        <p><strong>Car Brand:</strong> " . $row['brand'] . "</p>
                                        <p><strong>Car Model:</strong> " . $row['model'] . "</p>
                                        <p><strong>Total Price:</strong> " . $row['total_price'] ."$". "</p>
                                        <p><strong>Booking Date:</strong> " . $row['start_date'] . "</p>
                                        <p><strong>Return Date:</strong> " . $row['end_date'] . "</p>
                                        <p><strong>Booking Status:</strong> " . $row['status'] . "</p>
                                        <button class='canbtn' name='ok_" . $row['unique_id'] . "' type='submit'>Confirm</button>
                                         <button class='canbtn' name='can_" . $row['unique_id'] . "' type='submit'>Cancel</button>
                                        </div>
                                </div>";
                                if (isset($_POST["ok_" . $row['unique_id']])){
                                    $update_id = $row['unique_id'];
                                        $update_status = mysqli_query($conn,"UPDATE `book_car` SET `status`='Accepted!' WHERE `unique_id` = '$update_id'");
                                        echo "<script>alert('Booking Accepted!');</script>";
                                        echo "<script>window.location.href = 'profile.php';</script>";

                                }
                                if (isset($_POST["can_" . $row['unique_id']])){
                                    $update_id = $row['unique_id'];
                                        $update_status = mysqli_query($conn,"UPDATE `book_car` SET `status`='Rejected!' WHERE `unique_id` = '$update_id'");
                                        echo "<script>alert('Booking Rejected');</script>";
                                        echo "<script>window.location.href = 'profile.php';</script>";

                                }
                                
                            }
                        }
                        
                        else
                        {
                            echo "<p><h3>No Booking History Available...</h3></p>";
                        }
                    

                ?>
            </form>
        </div>
        <div class="booking">
            <h1>Booking History</h1>
            <form method="post">
                <?php
                // Fetch all booking records
                $book_car_sql = mysqli_query($conn, "SELECT * FROM `book_car` WHERE `uid` = '$user_id'");
                if (mysqli_num_rows($book_car_sql) > 0) {
                    while ($car_data = mysqli_fetch_assoc($book_car_sql)) {
                        $car_image = $car_data['img'];

                        echo "
                        <div class='booking-item'>
                            <img src='rent/$car_image' alt='Car Image' class='car-image'>
                            <div>
                                <p><strong>Car Brand:</strong> " . $car_data['brand'] . "</p>
                                <p><strong>Car Model:</strong> " . $car_data['model'] . "</p>
                                <p><strong>Total Price:</strong> " . $car_data['total_price'] ."$". "</p>
                                <p><strong>Booking Date:</strong> " . $car_data['start_date'] . "</p>
                                <p><strong>Return Date:</strong> " . $car_data['end_date'] . "</p>
                                <p><strong>Booking Status:</strong> " . $car_data['status'] . "</p>";
                                $car_status = $car_data['status'];
                                if($car_status == "Rejected!"){
                                    
                                echo "<button class='canbtn' name='ok1_" . $car_data['unique_id'] . "' type='submit'>&nbsp; &nbsp;  Ok &nbsp; &nbsp; </button>";
                                }
                                else
                                {
                                    echo "<button class='canbtn' name='b_" . $car_data['unique_id'] . "' type='submit'>Cancel Booking</button>";
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST["b_" . $car_data['unique_id']])){
                            $cancel_id = $car_data['unique_id'];
                            $cancel_car = mysqli_query($conn,"DELETE FROM `book_car` WHERE `unique_id` = '$cancel_id'");
                            if($cancel_car){
                                echo "<script>alert('Booking Cancelled')</script>";
                                echo "<script>window.open('profile.php','_self')</script>";
                            }
                        }
                        if (isset($_POST["ok1_" . $car_data['unique_id']])){
                            $ok_id = $car_data['unique_id'];
                            $update_status2 = mysqli_query($conn,"DELETE FROM `book_car` WHERE `unique_id` = '$ok_id'");
                            echo "<script>alert('Thanks For Confirmation!');</script>";
                            echo "<script>window.location.href = 'profile.php';</script>";
                        }
                    }
                } else {
                    echo "<p><h3>No Booking History Available...</h3></p>";
                }
                ?>
            </form>
        </div>
        <div class="booking">
            <h1>Rental History</h1>
            <form method="post">
                <?php
                // Fetch all rental records
                $rent_car_sql = mysqli_query($conn, "SELECT * FROM `car_rent` WHERE `id` = '$user_id'");
                if (mysqli_num_rows($rent_car_sql) > 0) {
                    while ($car_data2 = mysqli_fetch_assoc($rent_car_sql)) {
                        $car_image = $car_data2['image1'];

                        echo "
                        <div class='booking-item'>
                            <img src='rent/$car_image' alt='Car Image' class='car-image'>
                            <div>
                                <p><strong>Car Brand:</strong> " . $car_data2['car_brand'] . "</p>
                                <p><strong>Car Model:</strong> " . $car_data2['car_model'] . "</p>
                                <p><strong>Price Per Day :</strong> " . $car_data2['price_per_day'] ."$" ."</p>
                                <button class='canbtn' name='r_" . $car_data2['unique_id'] . "' type='submit'>Remove Car</button>
                            </div>
                        </div>";
                        if (isset($_POST["r_" . $car_data2['unique_id']])){
                            $remove_id = $car_data2['unique_id'];
                            $remove_car = mysqli_query($conn,"DELETE FROM `car_rent` WHERE `unique_id` = '$remove_id'");
                            $remove_cart = mysqli_query($conn,"DELETE FROM `cart` WHERE `unique_id` = '$remove_id'");
                            if($remove_car){
                                echo "<script>alert('Car Removed!')</script>";
                                echo "<script>window.open('profile.php','_self')</script>";
                            }
                        }
                    }
                } else {
                    echo "<p><h3>No Rental History Available...</h3></p>";
                }
                ?>
            </form>
        </div>
    </section>
    <footer>
        <p>&copy; 2018 Dabhi Car Rental. All Rights Reserved.</p>
    </footer>
</div>

<!-- Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="editForm" method="post" enctype="multipart/form-data">
            <label for="profilePicture">Profile Picture:</label>
            <input type="file" id="profilePicture" name="profilePicture"><br><br>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $nm; ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br><br>
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>"><br><br>
            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</div>

<script>
    // JavaScript for modal functionality
    var modal = document.getElementById("editModal");
    var btn = document.getElementById("editBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
