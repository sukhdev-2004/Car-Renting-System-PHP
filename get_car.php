<?php
session_start();
require("nav.php");
$unique_id = $_SESSION['unique_id'];
$id = $_SESSION['id'];
// session_abort();
$car_result = mysqli_query($conn, "SELECT * FROM car_rent WHERE `unique_id` = '$unique_id'");
$car = mysqli_fetch_assoc($car_result);
$rental_id = $car['id'];

// Initialize variables for form data
$name = $contact = $email = $start_date = $end_date = '';
$rentalDays = 0;
$totalPrice = 0.00;

if (isset($_POST['summary'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $contact_len = strlen($contact);

    // Calculate the number of days for the booking
    $start_date_time = new DateTime($start_date);
    $end_date_time = new DateTime($end_date);
    $interval = $start_date_time->diff($end_date_time);
    $rentalDays = $interval->days;

    // Calculate the total price
    $price_per_day = $car['price_per_day'];
    $totalPrice = $rentalDays * $price_per_day;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 40%;
            max-width: 1000px;
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

        input[type="text"], input[type="email"], input[type="number"], input[type="date"], input[type="number"], textarea {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
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

        .summary {
            margin-top: 20px;
            padding: 20px;
            width: 94%;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .summary p {
            margin: 10px 0;
            color: #333;
        }

        .summary .total-price {
            font-weight: bold;
            color: #000;
        }

        .car-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .car-image img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button{
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Car for Rent</h1>
        <form id="bookingForm" method="POST">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" required value="<?php echo $name; ?>">

            <label for="contact">Contact Number</label>
            <input type="number" id="contact" name="contact" required value="<?php echo $contact; ?>">

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required value="<?php echo $email; ?>">

            <label for="start_date">Rental Start Date</label>
            <input type="date" id="start_date" name="start_date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo $start_date; ?>">

            <label for="end_date">Rental End Date</label>
            <input type="date" id="end_date" name="end_date" min="<?php echo date('Y-m-d'); ?>" required value="<?php echo $end_date; ?>">

            <div class="car-image">
                <img src="rent/<?php echo $car['image1']; ?>" alt="Car Image">
            </div>

            <button name="summary">Get Summary</button>
       

        <?php if (isset($_POST['summary'])) { ?>
            <?php if($contact_len == 10) {?>
            <div class="summary" id="summary">
                <h2>Booking Summary</h2>
                <p><strong>Car:</strong> <?php echo $car['car_brand'] . " " . $car['car_model']; ?></p>
                <p><strong>Owner:</strong> <?php echo $car['owner_name']; ?></p>
                <p><strong>Contact:</strong> <?php echo $car['contact']; ?></p>
                <p><strong>Email:</strong> <?php echo $car['email']; ?></p>
                <p><strong>Rental Period:</strong> <?php echo ($start_date && $end_date) ? $start_date . ' To ' . $end_date : 'N/A'; ?> (<span id="rentalDays"><?php echo $rentalDays; ?></span> days)</p>
                <p class="total-price"><strong>Total Price:</strong> $<span id="totalPrice"><?php echo number_format($totalPrice, 2); ?></span></p>
               <br> <button name="book" type="submit">Book Now</button>
            </div>
        </form>
        <?php }
        else{
            echo "<script>alert('Invalid Contact Number!')</script>";
        }
    
    } ?>
    </div>
</body>
</html>
<?php
    if(isset($_POST["book"])){
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $image = $car['image1'];
        $model = $car['car_model'];
        $brand = $car['car_brand'];
        $contact_len = strlen($contact);
        $status = "Pending";
    
        // Calculate the number of days for the booking
        $start_date_time = new DateTime($start_date);
        $end_date_time = new DateTime($end_date);
        $interval = $start_date_time->diff($end_date_time);
        $rentalDays = $interval->days;
    
        // Calculate the total price
        $price_per_day = $car['price_per_day'];
        $totalPrice = $rentalDays * $price_per_day;
        $store_data = mysqli_query($conn,"INSERT INTO `book_car`(`img`,`brand`,`model`,`uid`, `name`, `contact`, `email`, `start_date`, `end_date`, `total_price`, `days`, `unique_id`, `rental_id`,`status`) VALUES ('$image','$brand','$model','$id','$name','$contact','$email','$start_date','$end_date','$totalPrice','$rentalDays','$unique_id','$rental_id','$status')");
        if($store_data){
            $_SESSION['pdf_bill'] = $unique_id;
            echo "<script>alert('Booking Successful!')</script>";
            echo "<script>window.location.href='pdf_bill.php';</script>";
           
    }
    
    else
    {
        echo "<script>alert('Not Booked!')</script>";
    }
    
}
?>