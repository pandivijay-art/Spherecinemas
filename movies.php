<?php
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sphere Cinemas & Festival</title>

<style>

body{
margin:0;
font-family: Arial, Helvetica, sans-serif;
background:#0f0f0f;
color:white;
}


header{
background:#111;
padding:15px 40px;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
font-size:22px;
font-weight:bold;
color:#ff2e63;
}


.movie-section{
display:flex;
align-items:center;
gap:40px;
padding:40px;
margin:30px;
background:linear-gradient(to right,#000,#1a1a1a);
border-radius:15px;
box-shadow:0 0 20px rgba(0,0,0,0.5);
transition:0.3s;
}

.movie-section:hover{
transform:scale(1.02);
box-shadow:0 0 25px #ff2e63;
}


.poster img{
width:260px;
height:350px;
object-fit:cover;
border-radius:12px;
}


.movie-info{
flex:1;
}

.movie-info h1{
font-size:35px;
margin-bottom:10px;
}

/* ⭐ */
.rating{
background:#1c1c1c;
padding:10px 15px;
border-radius:8px;
display:inline-block;
margin-bottom:10px;
}


.details{
color:#ccc;
margin-bottom:10px;
}


.tag{
background:#333;
padding:5px 10px;
border-radius:5px;
margin-right:8px;
}


.buttons{
margin-top:15px;
}

.btn{
padding:10px 20px;
border:none;
border-radius:6px;
cursor:pointer;
margin-right:10px;
}

.book{
background:#ff2e63;
color:white;
}

.trailer{
background:#444;
color:white;
}

</style>
</head>

<body>

<header>
<div class="logo">Sphere Cinemas & Festival</div>
</header>



<?php
$result = mysqli_query($conn,"SELECT * FROM movies");

while($row = mysqli_fetch_assoc($result)){
?>

<section class="movie-section">

<div class="poster">
<img src="<?php echo $row['image']; ?>">
</div>

<div class="movie-info">

<h1><?php echo $row['name']; ?></h1>

<div class="rating">
⭐ <?php echo $row['rating']; ?> 🎬 <?php echo $row['screen']; ?><br>
</div>
<br>
<div class="details">
<?php echo $row['duration']; ?> • <?php echo $row['category']; ?> • U • Latest
</div>
<br>
<div>
<span class="tag">3D</span>
<span class="tag"><?php echo $row['language']; ?></span>
<span class="tag"><?php echo $row['screen']; ?></span>
</div>
<br>

<button class="btn book"
onclick="window.location.href='booking.php?movie=<?php echo $row['name']; ?>&screen=<?php echo $row['screen']; ?>'">
Book Now
</button>

<button class="btn trailer"
onclick="window.open('<?php echo $row['trailer']; ?>')">
Watch Trailer
</button>

</div>

</div>

</section>

<?php
}
?>

</body>
</html>