<?php
session_start();
$conn = mysqli_connect("localhost","root","","newproject");

/* 🔥 FETCH ONLY SCREEN 2 BOOKED SEATS */
$result = mysqli_query($conn,"SELECT seats FROM bookings WHERE screen='Screen 2'");

$bookedSeats = [];

while($row = mysqli_fetch_assoc($result)){
    $seats = explode(",", $row['seats']);
    foreach($seats as $s){
        $bookedSeats[] = trim($s);
    }
}

/* MOVIE NAME */
$movie = isset($_GET['movie']) ? $_GET['movie'] : "Unknown Movie";

/* USER */
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Screen 2 Booking</title>

<style>

body{
background:#070b18;
color:white;
font-family:Arial;
text-align:center;
margin:0;
}

h1{
color:#00e5ff;
margin-top:20px;
}

/* SCREEN */
.screen{
width:450px;
height:80px;
margin:20px auto;
background:white;
color:black;
border-radius:50%/100%;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
}

/* TIME */
.time-container{
display:flex;
justify-content:center;
gap:15px;
margin:20px;
}

.time-btn{
background:#111;
color:white;
border:2px solid #00e5ff;
padding:10px 18px;
border-radius:20px;
cursor:pointer;
}

.time-btn.active{
background:#00e5ff;
color:black;
}

/* SEATS */
.container{
position:relative;
width:950px;
height:520px;
margin:auto;
}

.seat{
width:28px;
height:28px;
position:absolute;
border-radius:6px;
cursor:pointer;
font-size:9px;
line-height:28px;
text-align:center;
}

.silver{background:#2ecc71}
.gold{background:#3498db}
.vip{background:#9b59b6}

.selected{background:#f1c40f}

.booked{
background:#e74c3c;
cursor:not-allowed;
}

/* SUMMARY */
.summary{
margin-top:20px;
font-size:18px;
}

button{
margin-top:20px;
padding:10px 30px;
background:#00e5ff;
border:none;
color:black;
border-radius:5px;
cursor:pointer;
}

</style>
</head>

<body>

<h1>🎬 <?php echo $movie; ?> (SCREEN 2)</h1>

<div class="screen">SCREEN 2</div>

<h2>Select Show Time</h2>

<div class="time-container">
<button class="time-btn">11:00 AM</button>
</div>

<div class="container" id="seats"></div>

<div class="summary">
Seats: <span id="seatList">None</span><br>
Total Seats: <span id="count">0</span><br>
Total Price: ₹<span id="price">0</span>
</div>

<button onclick="confirmBooking()">Confirm Booking</button>

<script>

/* 🔥 BOOKED SEATS FROM DB */
let bookedSeats = <?php echo json_encode($bookedSeats); ?>;

const rows=[
{row:"A", seats:15, radius:120, type:"silver"},
{row:"B", seats:18, radius:150, type:"silver"},
{row:"C", seats:20, radius:180, type:"gold"},
{row:"D", seats:22, radius:210, type:"gold"},
{row:"E", seats:25, radius:240, type:"vip"},
{row:"F", seats:25, radius:270, type:"vip"},
{row:"G", seats:25, radius:300, type:"vip"}
];

const priceList={
silver:120,
gold:180,
vip:250
};

const container=document.getElementById("seats");

const centerX=475;
const centerY=0;

let selectedSeats=[];
let totalPrice=0;

/* CREATE SEATS */
rows.forEach(r=>{
for(let i=0;i<r.seats;i++){

let angle=(i/(r.seats-1))*Math.PI;

let x=centerX+r.radius*Math.cos(angle)-14;
let y=centerY+r.radius*Math.sin(angle);

let seat=document.createElement("div");

seat.className="seat "+r.type;
seat.innerText=r.row+(i+1);

/* BOOKED */
if(bookedSeats.includes(seat.innerText)){
seat.classList.add("booked");
}

seat.style.left=x+"px";
seat.style.top=y+"px";

seat.onclick=function(){

if(seat.classList.contains("booked")) return;

seat.classList.toggle("selected");

let seatNum=seat.innerText;

if(seat.classList.contains("selected")){
selectedSeats.push(seatNum);
totalPrice+=priceList[r.type];
}else{
selectedSeats=selectedSeats.filter(s=>s!==seatNum);
totalPrice-=priceList[r.type];
}

updateSummary();
}

container.appendChild(seat);
}
});

/* SUMMARY */
function updateSummary(){
document.getElementById("seatList").innerText=
selectedSeats.length?selectedSeats.join(", "):"None";

document.getElementById("count").innerText=selectedSeats.length;
document.getElementById("price").innerText=totalPrice;
}

/* CONFIRM */
function confirmBooking(){

if(selectedSeats.length===0){
alert("Select seats");
return;
}

let selectedTime=document.querySelector(".time-btn.active");

if(!selectedTime){
alert("Select show time");
return;
}

let time=selectedTime.innerText;
let seats=selectedSeats.join(",");
let price=totalPrice;

/* SAVE */
fetch("save_booking.php",{
method:"POST",
headers:{
"Content-Type":"application/x-www-form-urlencoded"
},
body:`username=<?php echo $username; ?>&movie_name=<?php echo $movie; ?>&show_time=${time}&seats=${seats}&price=${price}&screen=Screen 2`
})
.then(res=>res.text())
.then(data=>{
alert("Booking Saved ✅");

/* REDIRECT */
window.location.href="payment.php?movie=<?php echo $movie; ?>&seats="+seats+"&time="+time;
});
}

/* TIME SELECT */
let timeButtons=document.querySelectorAll(".time-btn");

timeButtons.forEach(btn=>{
btn.onclick=function(){
timeButtons.forEach(b=>b.classList.remove("active"));
this.classList.add("active");
}
});

</script>

</body>
</html>