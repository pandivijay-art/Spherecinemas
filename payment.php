<?php
session_start(); 

$movie = isset($_GET['movie']) ? $_GET['movie'] : "Unknown Movie";
$seats = isset($_GET['seats']) ? $_GET['seats'] : "";
$time = isset($_GET['time']) ? $_GET['time'] : "Not Selected";

$seatArray = explode(",", $seats);
$totalSeats = ($seats == "") ? 0 : count($seatArray);

$pricePerSeat = 180;
$total = $totalSeats * $pricePerSeat;
?>
<!DOCTYPE html>
<html>
<head>
<title>Payment Gateway</title>

<style>
/* ✅ OLD CSS UNCHANGED */
body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#0f0f0f,#1c1c1c);
color:white;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}
.box{
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:15px;
backdrop-filter:blur(10px);
box-shadow:0 0 25px rgba(255,46,99,0.3);
width:350px;
text-align:center;
}
h1{color:#ff2e63;}
p{margin:10px 0;}
.btn{
width:100%;
padding:12px;
margin-top:10px;
border:none;
border-radius:6px;
cursor:pointer;
}
.upi{background:#00c853;color:white;}
.card{background:#555;color:white;}
.net{background:#333;color:white;}
.pay{background:#ff2e63;color:white;}
.apps{
display:flex;
justify-content:space-around;
margin-top:15px;
}
.app img{width:40px;}
.selectedApp{border:2px solid #00e5ff;}
input, select{
width:100%;
padding:10px;
margin-top:10px;
border:none;
border-radius:6px;
background:#222;
color:white;
}
</style>
</head>

<body>

<div class="box">

<h1>💳 Payment Gateway</h1>

<p><b>Movie :</b> <?php echo $movie; ?></p>
<p><b>Show Time :</b> <?php echo $time; ?></p>
<p><b>Seats :</b> <?php echo ($seats == "" ? "None" : $seats); ?></p>

<p><b>Total Price :</b> ₹<span id="totalAmount"><?php echo $total; ?></span></p>

<h3>Apply Offer Code</h3>

<input type="text" id="coupon" placeholder="Enter Code">
<button class="btn" onclick="applyCoupon()" style="background:#00e5ff;color:black;">
Apply Code
</button>

<p id="discountMsg"></p>

<h3>Select Payment Method</h3>

<button class="btn upi" onclick="showUPI()">UPI Payment</button>
<button class="btn card" onclick="showCard()">Card</button>
<button class="btn net" onclick="showNet()">Net Banking</button>

<div id="upiBox">
<div class="apps">
<div class="app" onclick="selectApp(this)">
<img src="https://img.icons8.com/color/48/google-pay.png">
</div>
<div class="app" onclick="selectApp(this)">
<img src="https://images.seeklogo.com/logo-png/50/3/phonepe-logo-png_seeklogo-507202.png">
</div>
<div class="app" onclick="selectApp(this)">
<img src="https://img.icons8.com/color/48/paytm.png">
</div>
</div>
<input type="text" placeholder="Enter UPI ID">
</div>

<div id="cardBox" style="display:none;">
<input type="text" placeholder="Card Number">
<input type="text" placeholder="Expiry">
<input type="text" placeholder="CVV">
</div>

<div id="netBox" style="display:none;">
<select>
<option>Select Bank</option>
<option>SBI</option>
<option>HDFC</option>
</select>
</div>

<button class="btn pay" onclick="payNow()">Pay Now</button>

</div>

<script>

let originalTotal = <?php echo $total; ?>;
let finalTotal = originalTotal;


let userRole = "<?= isset($_SESSION['role']) ? $_SESSION['role'] : 'user' ?>";

function applyCoupon(){
let code = document.getElementById("coupon").value.trim().toUpperCase();
let msg = document.getElementById("discountMsg");

if(code === "POPCORN50"){
    finalTotal = originalTotal * 0.5;
    msg.innerText = "🎉 50% Discount Applied!";
}
else if(code === "STUDENT30"){

    // 🔐 STUDENT CHECK
    if(userRole !== "student"){
        msg.innerText = "❌ Only for students";
        return;
    }

    finalTotal = originalTotal * 0.7;
    msg.innerText = "🎉 30% Discount Applied!";
}
else{
    finalTotal = originalTotal;
    msg.innerText = "❌ Invalid Code";
}

document.getElementById("totalAmount").innerText = Math.floor(finalTotal);
}

function showUPI(){
document.getElementById("upiBox").style.display="block";
document.getElementById("cardBox").style.display="none";
document.getElementById("netBox").style.display="none";
}

function showCard(){
document.getElementById("upiBox").style.display="none";
document.getElementById("cardBox").style.display="block";
document.getElementById("netBox").style.display="none";
}

function showNet(){
document.getElementById("upiBox").style.display="none";
document.getElementById("cardBox").style.display="none";
document.getElementById("netBox").style.display="block";
}

function selectApp(el){
document.querySelectorAll(".app").forEach(a=>a.classList.remove("selectedApp"));
el.classList.add("selectedApp");
}

function payNow(){

alert("Payment Successful 🎉");

let urlParams = new URLSearchParams(window.location.search);

let movie = urlParams.get("movie");
let seats = urlParams.get("seats");
let time = urlParams.get("time");
let screen = urlParams.get("screen");
let date = urlParams.get("date");     

let bookingId = "SPH" + Math.floor(Math.random() * 1000000);

let username = "<?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest' ?>";

// ✅ FINAL FIX
window.location.href =
"save_booking.php?username="+username+
"&movie_name="+movie+
"&show_time="+time+
"&seats="+seats+
"&screen="+screen+     
"&date="+date+         
"&booking_id="+bookingId;

}
window.onload = showUPI;

</script>

</body>
</html>