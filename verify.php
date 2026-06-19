<?php
$conn = mysqli_connect("localhost","root","","newproject");


$id = $_GET['booking_id'] ?? ($_GET['id'] ?? "");

$id = mysqli_real_escape_string($conn, $id);

$data = mysqli_query($conn,"SELECT * FROM bookings WHERE booking_id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html>
<head>
<title>Ticket Verification</title>

<style>
body{
    font-family:Arial;
    background:#0f172a;
    color:white;
    text-align:center;
    padding-top:100px;
}

.box{
    background:#1e293b;
    padding:30px;
    border-radius:15px;
    width:350px;
    margin:auto;
    box-shadow:0 0 20px rgba(0,0,0,0.5);
}

.valid{color:#00e676;}
.used{color:#ff5252;}
.invalid{color:#ff1744;}
</style>

</head>
<body>

<div class="box">

<?php
if(!$row){
    echo "<h2 class='invalid'>❌ INVALID TICKET</h2>";
}
else{

   
    if($row['status']=="used"){
        echo "<h2 class='used'>🔴 ALREADY USED</h2>";
    }
    else{

        $current_time = date("H:i:s");
        $show_time = date("H:i:s", strtotime($row['show_time']));

        if($current_time < $show_time){
            echo "<h2 class='invalid'>⏰ TOO EARLY</h2>";
        }
        else{
            echo "<h2 class='valid'>🟢 ENTRY ALLOWED</h2>";

        
            mysqli_query($conn,"UPDATE bookings SET status='used' WHERE booking_id='$id'");
        }
    }

    
    echo "<p>🎬 ".$row['movie_name']."</p>";
    echo "<p>💺 ".$row['seats']."</p>";
    echo "<p>🕒 ".$row['show_time']."</p>";
}
?>

</div>

</body>
</html>