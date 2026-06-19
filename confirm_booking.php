<?php
include "db.php";

$username = $_POST['username'];
$movie = $_POST['movie'];
$time = $_POST['time'];
$seats = $_POST['seats'];

$sql = "INSERT INTO bookings (username, movie_name, show_time, seats)
VALUES ('$username', '$movie', '$time', '$seats')";

mysqli_query($conn,$sql);

echo "Booking Successful";
?>