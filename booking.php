<?php
session_start();
$conn = mysqli_connect("localhost","root","","newproject");

$screen = trim($_GET['screen'] ?? "Screen1");
$movie = $_GET['movie'] ?? "Unknown Movie";
$username = $_SESSION['username'] ?? "Guest";

$times = ["11:00 AM"];

$timeData = mysqli_query($conn,"SELECT show_time FROM movies WHERE name='$movie'");
$timeRow = mysqli_fetch_assoc($timeData);

if($timeRow && !empty($timeRow['show_time'])){
    $times = [trim($timeRow['show_time'])];
}

$selectedTime = $_GET['time'] ?? $times[0];
$selectedDate = "2026-04-06"; // FIXED DATE

$selectedTime = trim($selectedTime);

$result = mysqli_query($conn,"
SELECT seats FROM bookings 
WHERE LOWER(TRIM(screen))=LOWER(TRIM('$screen')) 
AND movie_name='$movie'
AND TRIM(show_time)=TRIM('$selectedTime')
AND show_date='$selectedDate'
");

$bookedSeats = [];

while($row = mysqli_fetch_assoc($result)){
    $seatArr = explode(",", $row['seats']);
    foreach($seatArr as $s){
        $seat = trim($s);
        if(!in_array($seat, $bookedSeats)){
            $bookedSeats[] = $seat;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Booking</title>

<style>
body{
margin:0;
font-family:Arial;
background:radial-gradient(circle at top,#0f172a,#020617);
color:white;
text-align:center;
}

h1{color:#ffd700;text-shadow:0 0 10px gold;}

.screen{
width:500px;height:90px;margin:30px auto;
background:white;color:black;border-radius:50%/100%;
display:flex;align-items:center;justify-content:center;
box-shadow:0 0 30px rgba(255,255,255,0.4);
}

.container{
position:relative;width:950px;height:520px;margin:auto;
}

.seat{
width:30px;height:30px;position:absolute;border-radius:8px;
cursor:pointer;font-size:9px;line-height:30px;text-align:center;
}

.silver{background:#22c55e}
.gold{background:#3b82f6}
.vip{background:#a855f7}

.selected{background:#facc15}
.booked{background:red;cursor:not-allowed}

.summary{
margin-top:20px;background:rgba(255,255,255,0.05);
padding:15px;border-radius:10px;width:300px;margin:auto;
}

button{
margin-top:20px;padding:14px 35px;
background:linear-gradient(45deg,#ff2e63,#ff6b81);
border:none;color:white;border-radius:8px;
cursor:pointer;
}
</style>
</head>

<body>

<h1>🎬 <?php echo $movie; ?></h1>
<div class="screen"><?php echo $screen; ?></div>

<h2>Select Date</h2>

<!-- ✅ FIXED DATE -->
<input type="date" id="showDate"
value="2026-04-06"
min="2026-04-06"
max="2026-04-06"
readonly>

<h2>Show Time</h2>

<?php foreach($times as $t){ ?>
<button><?php echo $t; ?></button>
<?php } ?>

<div class="container" id="seats"></div>

<div class="summary">
Seats: <span id="seatList">None</span><br>
Total Seats: <span id="count">0</span><br>
Total Price: ₹<span id="price">0</span>
</div>

<button onclick="confirmBooking()">Confirm Booking</button>

<script>

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

const priceList={silver:120,gold:180,vip:250};

const container=document.getElementById("seats");

let selectedSeats=[];
let totalPrice=0;

rows.forEach(r=>{
for(let i=0;i<r.seats;i++){

let angle=(i/(r.seats-1))*Math.PI;
let x=475+r.radius*Math.cos(angle)-14;
let y=0+r.radius*Math.sin(angle);

let seat=document.createElement("div");

seat.className="seat "+r.type;
seat.innerText=r.row+(i+1);

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

function updateSummary(){
document.getElementById("seatList").innerText=
selectedSeats.length?selectedSeats.join(", "):"None";

document.getElementById("count").innerText=selectedSeats.length;
document.getElementById("price").innerText=totalPrice;
}

function confirmBooking(){

let date = document.getElementById("showDate").value;

if(selectedSeats.length === 0){
alert("Select seats");
return;
}

let seats = encodeURIComponent(selectedSeats.join(","));

let movie = "<?php echo urlencode($movie); ?>";
let screen = "<?php echo urlencode($screen); ?>";
let time = "<?php echo urlencode($selectedTime); ?>";

let url = "payment.php?movie=" + movie +
"&screen=" + screen +
"&time=" + time +
"&date=" + date +
"&seats=" + seats;

window.location.href = url;
}

</script>

</body>
</html>