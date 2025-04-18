<?php 

    $conn=mysqli_connect("localhost","root","","ty project");
    if(!$conn)
    {
        echo "<script>alert('Not Connected');</script>";
    }

?>