<?php

require "pdf_conn.php";
require "fpdf/fpdf.php";
session_start();

$unique_id = $_SESSION['pdf_bill'];
session_abort();

$bill = mysqli_query($conn, "SELECT * FROM `book_car` WHERE `unique_id` = '$unique_id'");
$bill_data = mysqli_fetch_assoc($bill);

//======  Customer information ======
$nm = $bill_data['name'];
$phone = $bill_data['contact'];
$email = $bill_data['email'];
$uid = $bill_data['uid'];

// ======  Owner information ======
$rental_id = $bill_data['rental_id'];
$rental = mysqli_query($conn, "SELECT * FROM `car_rent` WHERE `id` = '$rental_id'");
$rental_data = mysqli_fetch_assoc($rental);
$r_nm = $rental_data['owner_name'];
$r_phone = $rental_data['contact'];
$r_email = $rental_data['email'];

// ====== Car Information ======
$start_date = $bill_data['start_date'];
$end_date = $bill_data['end_date'];
$price = $bill_data['total_price'].' $';
$brand = $bill_data['brand'];
$model = $bill_data['model'];
$days = $bill_data['days'] . " Days";

// Creating PDF ================================
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(190, 10, 'Car Booking Bill', 1, 1, 'C');

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Customer Information', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(150, 10, $nm, 1, 1);
$pdf->Cell(40, 10, 'User Id', 1);
$pdf->Cell(150, 10, $uid, 1, 1);
$pdf->Cell(40, 10, 'Phone', 1);
$pdf->Cell(150, 10, $phone, 1, 1);
$pdf->Cell(40, 10, 'Email Id', 1);
$pdf->Cell(150, 10, $email, 1, 1);

$pdf->Cell(190, 10, '', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Owner Information', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Name', 1);
$pdf->Cell(150, 10, $r_nm, 1, 1);
$pdf->Cell(40, 10, 'Phone', 1);
$pdf->Cell(150, 10, $r_phone, 1, 1);
$pdf->Cell(40, 10, 'Email Id', 1);
$pdf->Cell(150, 10, $r_email, 1, 1);

$pdf->Cell(190, 10, '', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 10, 'Car Booking Information', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Car Brand', 1);
$pdf->Cell(150, 10, $brand, 1, 1);
$pdf->Cell(40, 10, 'Car Model', 1);
$pdf->Cell(150, 10, $model, 1, 1);
$pdf->Cell(40, 10, 'Start Date', 1);
$pdf->Cell(150, 10, $start_date, 1, 1);
$pdf->Cell(40, 10, 'End Date', 1);
$pdf->Cell(150, 10, $end_date, 1, 1);
$pdf->Cell(40, 10, 'Total Days', 1);
$pdf->Cell(150, 10, $days, 1, 1);
$pdf->Cell(150, 10, 'Total Payment', 1);
$pdf->Cell(40, 10, $price, 1, 1);
$pdf_name = $uid.".pdf";
$pdf->output($pdf_name,'D');  

?>
