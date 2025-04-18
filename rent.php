<?php
session_start();
require ("nav.php");
$id = $_SESSION['id'];
session_abort();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Your Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"], input[type="number"], textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #575757;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rent Your Car</h1>
        <form method="POST" enctype="multipart/form-data">
            <label for="owner_name">Owner's Name</label>
            <input type="text" id="owner_name" name="owner_name" required>

            <label for="contact">Contact Number</label>
            <input type="number" id="contact" name="contact" required>

            <label for="email">Email Address</label>
            <input type="text" id="email" name="email" required>

            <label for="car_make">Car Brand</label>
            <input type="text" id="car_make" name="car_make" required>

            <label for="car_model">Car Model</label>
            <input type="text" id="car_model" name="car_model" required>

            <label for="year">Year of Manufacture</label>
            <input type="number" id="year" name="year" required>

            <label for="color">Color</label>
            <input type="text" id="color" name="color" required>

            <label for="mileage">Mileage (km)</label>
            <input type="number" id="mileage" name="mileage" required>

            <label for="price_per_day">Price Per Day ($)</label>
            <input type="number" id="price_per_day" name="price" required>

            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5" required></textarea>

            <label for="image1">Car Image 1</label>
            <input type="file" id="image1" name="image1" accept="image/*" required>

            <label for="image2">Car Image 2</label>
            <input type="file" id="image2" name="image2" accept="image/*" required>

            <label for="image3">Car Image 3</label>
            <input type="file" id="image3" name="image3" accept="image/*" required>

            <label for="image4">Car Image 4</label>
            <input type="file" id="image4" name="image4" accept="image/*" required>

            <button type="submit" name="rent">Submit</button>
        </form>
    </div>
</body>
</html>

<?php

if(isset($_POST['rent'])) {
    $owner_name = $_POST['owner_name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $car_brand = $_POST['car_make'];
    $car_model = $_POST['car_model'];
    $year = $_POST['year'];
    $color = $_POST['color'];
    $mileage = $_POST['mileage'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $date1 = date("d-m-Y");
    $target_dir = "rent/";
    $image1 = $_FILES["image1"]["name"];
    $image2 = $_FILES["image2"]["name"];
    $image3 = $_FILES["image3"]["name"];
    $image4 = $_FILES["image4"]["name"];

    $contact1 = strlen($contact);
    $year1 = strlen($year);
    $img1 = strlen($image1);
    $img2 = strlen($image2);
    $img3 = strlen($image3);
    $img4 = strlen($image4);
    $randomNumber = rand(1000000000, 9999999999); 
    $unique_id = "P_".$randomNumber;
    

        if($contact1 == 10)
        {
            if($year1 == 4)
            {
                if($img1 > 3 && $img2 > 3 && $img3 > 3 && $img4 > 3)
                {
                 move_uploaded_file($_FILES["image1"]["tmp_name"], $target_dir . $image1);
                 move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir . $image2);
                 move_uploaded_file($_FILES["image3"]["tmp_name"], $target_dir . $image3);
                 move_uploaded_file($_FILES["image4"]["tmp_name"], $target_dir . $image4);

                 $rent_car = mysqli_query($conn, "INSERT INTO `car_rent`(`id`,`unique_id`, `owner_name`, `contact`, `email`, `car_brand`, `car_model`, `year_of_manufacture`, `color`, `mileage`, `price_per_day`, `description`, `image1`, `image2`, `image3`, `image4`, `rent_date`) VALUES ('$id','$unique_id', '$owner_name', '$contact', '$email', '$car_brand', '$car_model', '$year', '$color', '$mileage', '$price', '$description', '$image1', '$image2', '$image3', '$image4', '$date1')");

                 if($rent_car){
                     echo "<script>alert('Car Rented Successfully')</script>";
                     echo "<script>window.location.href='home.php';</script>";  
                 } else {
                     echo "<script>alert('Error Renting car!')</script>";
                 }
                }
                else
                {
                    echo "<script>alert('Please Upload 4 Images!')</script>";
                }
            }
            else
            {
                echo "<script>alert('Please Enter 4 Digit Year!')</script>";
            }
        }
        else
        {
            echo "<script>alert('Please Enter 10 Digit Contact Number!')</script>";
        }

    
}
?>
