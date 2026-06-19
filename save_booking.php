<?php

$conn = mysqli_connect("localhost","root","","newproject");

session_start();

$bookingId = "SPH".rand(100000,999999);

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    $username = $_POST['username'] ?? $_GET['username'] ?? "Guest";
}

$movie = $_POST['movie_name'] ?? $_GET['movie_name'] ?? "";
$time = $_POST['show_time'] ?? $_GET['show_time'] ?? "";
$seats = $_POST['seats'] ?? $_GET['seats'] ?? "";
$screen = $_POST['screen'] ?? $_GET['screen'] ?? "";
$show_date = $_POST['date'] ?? $_GET['date'] ?? "";

$booking_date = date("Y-m-d H:i:s");



if($screen == ""){
    echo "Screen missing ❌";
    exit();
}

if($seats == ""){
    echo "No seats selected ❌";
    exit();
}



$sql = "INSERT INTO bookings
(booking_id, username, movie_name, show_time, seats, screen, show_date, booking_date)
VALUES
('$bookingId','$username','$movie','$time','$seats','$screen','$show_date','$booking_date')";


if(mysqli_query($conn,$sql)){
    
    header("Location: ticket.php?movie=$movie&time=$time&seats=$seats&booking_id=$bookingId");
    exit();

}else{
    echo "error: ".mysqli_error($conn);
}

?>