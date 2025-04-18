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
    <title>Contact Us - Dabhi Car Rental</title>
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

header p {
    margin: 0;
    font-size: 1.2em;
    color: #666;
}

.contact {
    padding: 20px 0;
}

.contact h2 {
    font-size: 2em;
    color: #333;
    margin-bottom: 10px;
}

.contact p {
    font-size: 1em;
    color: #666;
    line-height: 1.6;
    margin-bottom: 20px;
}

.contact-details {
    margin-bottom: 20px;
}

.contact-details h3 {
    font-size: 1.5em;
    color: #444;
    margin-bottom: 10px;
}

.contact-details p {
    font-size: 1em;
    color: #666;
    margin: 5px 0;
}

.contact-form {
    margin-bottom: 20px;
}

.contact-form h3 {
    font-size: 1.5em;
    color: #444;
    margin-bottom: 10px;
}

.contact-form label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.contact-form button {
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.contact-form button:hover {
    background-color: #555;
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

   </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Dabhi Car Rental</h1>
            <p>Your Trusted Car Rental Partner</p>
        </header>
        <section class="contact">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! Whether you have a question, feedback, or need assistance, our team is here to help.</p>
            
            <div class="contact-details">
                <h3>Our Contact Information</h3>
                <p><strong>Address : </strong>B/32 Shreeji Complex, Nana Varacha , Surat 395006 </p>
                <p><strong>Phone : </strong>+91 8799467464 </p>
                <p><strong>Email : </strong>dabhiyuvraj1204@gmail.com</p>
            </div>
            
            <div class="contact-form">
                <h3>Send Us a Message</h3>
                <form method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    
                    <button type="submit" name="massage">Submit</button>
                </form>
            </div>
        </section>
        <footer>
            <p>&copy; 2018 Dabhi Car Rental. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
<?php
    if(isset($_POST['massage'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];

    $store = mysqli_query($conn,"INSERT INTO `con_detail`(`name`,`uid`, `email`, `subject`, `msg`) VALUES ('$name','$id','$email','$subject','$message')");
        if($store)
        {
            echo "<script>alert('Send Successfully');</script>";
        }
        else
        {
            echo "<script>alert('Send Failed!');</script>";
        }
}

?>
