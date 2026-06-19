<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Booking Report Analysis</title>

<style>

body{
    font-family: Arial;
    background:#0f0f0f;
    color:white;
    margin:0;
}


h2{
    text-align:center;
    padding:20px;
}

/* CARDS */
.container{
    display:flex;
    justify-content:center;
    gap:30px;
    margin-bottom:30px;
}

.card{
    background:#1c1c1c;
    padding:20px 40px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 0 10px rgba(0,0,0,0.5);
}

.card h3{
    color:#ff2e63;
    margin-bottom:10px;
}


table{
    width:90%;
    margin:auto;
    border-collapse:collapse;
    background:#1a1a1a;
}

th, td{
    padding:12px;
    text-align:center;
}

th{
    background:#ff2e63;
}

tr:nth-child(even){
    background:#222;
}

</style>
</head>

<body>

<h2>📊 Booking Report</h2>

<?php


$r1 = mysqli_query($conn,"SELECT COUNT(*) as total FROM bookings");
$d1 = mysqli_fetch_assoc($r1);
$totalBookings = $d1['total'];


$r2 = mysqli_query($conn,"SELECT seats FROM bookings");
$totalSeats = 0;

while($row = mysqli_fetch_assoc($r2)){
    $seats = explode(",", $row['seats']);
    $totalSeats += count($seats);
}


$ticket_price = 120;
$totalRevenue = $totalSeats * $ticket_price;

?>


<div class="container">

<div class="card">
<h3>Total Bookings</h3>
<p><?php echo $totalBookings; ?></p>
</div>

<div class="card">
<h3>Total Seats</h3>
<p><?php echo $totalSeats; ?></p>
</div>

<div class="card">
<h3>Total Revenue</h3>
<p>₹<?php echo $totalRevenue; ?></p>
</div>

</div>


<table>

<tr>
<th>ID</th>
<th>userName</th>
<th>Movie_name</th>
<th>show_Time</th>
<th>Seats</th>
<th>booking_date</th>
</tr>

<?php


$result = mysqli_query($conn,"SELECT * FROM bookings ORDER BY id DESC");

while($row = mysqli_fetch_assoc($result)){
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['movie_name']; ?></td>
<td><?php echo $row['show_time']; ?></td>
<td><?php echo $row['seats']; ?></td>
<td><?php echo $row['booking_date']; ?></td>
</tr>

<?php
}
?>

</table>

</body>
</html>