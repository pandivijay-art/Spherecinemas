<?php
$conn = mysqli_connect("localhost","root","","newproject");

if(isset($_POST['send'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $phone=$_POST['phone'];

    mysqli_query($conn,"INSERT INTO contact_messages 
(name,email,subject,message,phone,status) 
VALUES 
('$name','$email','$subject','$message','$phone','new')");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sphere Cinema | Contact</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:linear-gradient(135deg,#000000,#0f2027);
color:white;
}

/* NAVBAR */

nav{
display:flex;
justify-content:center;
gap:40px;
padding:20px;
background:black;
}

nav a{
text-decoration:none;
color:white;
font-weight:500;
transition:.3s;
}

nav a:hover{
color:#00e5ff;
}

/* HEADER */

.contact-header{
text-align:center;
padding:60px;
}

.contact-header h1{
font-size:45px;
color:#00e5ff;
}



.contact-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:40px;
padding:40px 10%;
}



.info-box{
background:rgba(255,255,255,0.05);
backdrop-filter:blur(10px);
padding:30px;
border-radius:15px;
box-shadow:0 0 25px rgba(0,229,255,0.3);
}

.info-box h2{
margin-bottom:20px;
color:#00e5ff;
}

.info-item{
margin:15px 0;
font-size:16px;
}



.contact-form{
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:15px;
box-shadow:0 0 25px rgba(0,229,255,0.3);
}

.contact-form input,
.contact-form textarea{
width:100%;
padding:12px;
margin:12px 0;
border:none;
border-radius:8px;
background:#111;
color:white;
}

.contact-form textarea{
height:120px;
}

.contact-form button{
width:100%;
padding:14px;
background:#00e5ff;
border:none;
border-radius:8px;
font-size:16px;
cursor:pointer;
transition:.3s;
}

.contact-form button:hover{
background:#00bcd4;
transform:scale(1.05);
}

/* MAP */

.map{
margin:40px 10%;
border-radius:15px;
overflow:hidden;
box-shadow:0 0 25px rgba(0,229,255,0.4);
}

/* FOOTER */

footer{
text-align:center;
padding:20px;
background:black;
margin-top:50px;
color:#aaa;
}

@media(max-width:900px){
.contact-grid{
grid-template-columns:1fr;
}
}

</style>
</head>

<body>



<nav>
<a href="index.html">Home</a>
<a href="movies.php">Movies</a>
<a href="instruction.html">Facilities</a>
<a href="contact.php">Contacts</a>
<a href="offers.html">Offers</a>
</nav>



<div class="contact-header">
<h1>Sphere Cinema Review Board🎬</h1>
<p>Have questions? Reach out to us anytime.</p>
</div>


<div class="contact-grid">



<div class="info-box">
<h2>Contact Information</h2>
<div class="info-item">📍 The american collge Road,Madurai</div>
<div class="info-item">📞 +91 9597227440</div>
<div class="info-item">📧 support@spherecinema.com</div>
<div class="info-item">🕒 Open : 9 AM  to 12 AM</div>
</div>



<div class="contact-form">
<h2>Send Message</h2>

<form action="" method="POST">

<input type="text" name="name" placeholder="Your Name" required>

<input type="email" name="email" placeholder="Your Email" required>

<input type="text" name="subject" placeholder="Subject">

<textarea name="message" placeholder="Your Message & Reviews"></textarea>
<input type ="text" name="phone" placeholder ="your phone number" required>

<button type="submit" name="send">Send Message</button>

</form>

</div>

</div>

<!-- MAP -->

<div class="map">
<iframe
width="100%"
height="350"
src="https://maps.google.com/maps?q=chennai&t=&z=13&ie=UTF8&iwloc=&output=embed">
</iframe>
</div>

<footer>
© 2026 Sphere Cinema | All Rights Reserved 🎬
</footer>

</body>
</html>