<?php
date_default_timezone_set("Asia/Kolkata");

include "phpqrcode/qrlib.php";


$movie = isset($_GET['movie']) ? $_GET['movie'] : "No Movie";
$seats = isset($_GET['seats']) ? $_GET['seats'] : "No Seats";
$time  = isset($_GET['time'])  ? $_GET['time']  : "No Time";

if($seats == "" || $seats == "null"){
    $seats = "No Seats";
}


$bookingId = isset($_GET['booking_id']) ? $_GET['booking_id'] : "UNKNOWN";

$date = date("d M Y, h:i A");

session_start();
$user = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";


$host = $_SERVER['HTTP_HOST'];
$qrData = "http://".$host."/newproject/verify.php?id=".$bookingId;


if(!file_exists("qrcodes")){
    mkdir("qrcodes");
}

$qrFile = "qrcodes/".$bookingId.".png";
QRcode::png($qrData, $qrFile, QR_ECLEVEL_L, 5);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sphere Ticket</title>

<style>
body{
margin:0;
font-family:Arial;
background:#000;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
color:white;
}

.ticket{
width:420px;
background:linear-gradient(135deg,#1c1c1c,#0f0f0f);
border-radius:20px;
box-shadow:0 0 40px rgba(255,46,99,0.6);
overflow:hidden;
animation:pop 0.5s ease;
}

.header{
background:#ff2e63;
padding:15px;
text-align:center;
font-size:20px;
font-weight:bold;
}

.content{padding:20px;}

.row{
display:flex;
justify-content:space-between;
margin:10px 0;
font-size:14px;
}

.highlight{
color:#00e5ff;
font-weight:bold;
}

.qr{text-align:center;margin-top:15px;}

.qr img{
width:150px;
border-radius:10px;
background:white;
padding:5px;
transition:0.3s;
}

.qr img:hover{
transform:scale(1.1);
}

.footer{
padding:15px;
text-align:center;
border-top:1px dashed #444;
}

.btn{
margin-top:10px;
padding:10px;
width:90%;
border:none;
border-radius:6px;
cursor:pointer;
font-size:14px;
}

.print{background:#00c853;color:white;}
.home{background:#ff2e63;color:white;}

.btn:hover{opacity:0.8;}

@keyframes pop{
from{transform:scale(0.7);opacity:0;}
to{transform:scale(1);opacity:1;}
}
</style>

<script>
function printTicket(){
    window.print();
}

function goHome(){
    window.location.replace("/NEWPROJECT/index.html");
}

function copyID(){
    navigator.clipboard.writeText("<?php echo $bookingId; ?>");
    alert("Booking ID Copied ✅");
}
</script>

</head>

<body>

<div class="ticket">

<div class="header">
🎟 Sphere Cinemas Ticket
</div>

<div class="content">

<div class="row">
<span>Booking ID</span>
<span class="highlight">#<?php echo $bookingId; ?></span>
</div>

<div class="row">
<span>Movie</span>
<span class="highlight"><?php echo $movie; ?></span>
</div>

<div class="row">
<span>Show Time</span>
<span><?php echo $time; ?></span>
</div>

<div class="row">
<span>Seats</span>
<span class="highlight"><?php echo $seats; ?></span>
</div>

<div class="row">
<span>Date</span>
<span><?php echo $date; ?></span>
</div>

<div class="row">
<span>User</span>
<span><?php echo $user; ?></span>
</div>

<!-- ✅ QR -->
<div class="qr">
<a href="<?php echo $qrData; ?>" target="_blank">
<img src="<?php echo $qrFile; ?>">
</a>
<p style="font-size:12px;color:gray;">Scan at entry gate</p>
</div>

</div>

<div class="footer">

<button class="btn print" onclick="printTicket()">
📄 Download Ticket
</button>

<button class="btn home" onclick="goHome()">
🏠 Back to Home
</button>

<button class="btn" onclick="copyID()" style="background:#00e5ff;color:black;">
📋 Copy Booking ID
</button>

</div>

</div>

</body>
</html>