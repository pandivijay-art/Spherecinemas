<?php
include "db.php";

$id = $_GET['id'];


$data = mysqli_query($conn,"SELECT * FROM movies WHERE id=$id");
$row = mysqli_fetch_assoc($data);


if(isset($_POST['update'])){

$name = $_POST['name'];
$image = $_POST['image'];
$price = $_POST['price'];
$rating = $_POST['rating'];
$duration = $_POST['duration'];
$category = $_POST['category'];
$language = $_POST['language'];
$screen = $_POST['screen'];
$trailer = $_POST['trailer'];

mysqli_query($conn,"UPDATE movies SET
name='$name',
image='$image',
price='$price',
rating='$rating',
duration='$duration',
category='$category',
language='$language',
screen='$screen',
trailer='$trailer'
WHERE id=$id");


header("Location: movies.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Movie</title>

<style>

body{
margin:0;
font-family:Arial;
background:linear-gradient(135deg,#0f0f0f,#1c1c1c);
color:white;
}


.form-box{
background:rgba(255,255,255,0.05);
padding:30px;
border-radius:15px;
backdrop-filter:blur(10px);
box-shadow:0 0 25px rgba(255,46,99,0.3);
width:350px;
margin:60px auto;
text-align:center;
}

.form-box h2{
margin-bottom:20px;
color:#ff2e63;
}


input{
width:100%;
padding:10px;
margin:10px 0;
border:none;
border-radius:6px;
background:#1a1a1a;
color:white;
outline:none;
}

input:focus{
box-shadow:0 0 8px #ff2e63;
}


button{
width:100%;
padding:12px;
border:none;
border-radius:6px;
background:#ff2e63;
color:white;
cursor:pointer;
transition:0.3s;
}

button:hover{
background:#ff4f7a;
transform:scale(1.05);
}


.preview{
width:100%;
height:180px;
object-fit:cover;
margin-top:10px;
border-radius:10px;
}

</style>

<script>


function previewURL(){
let url = document.getElementById("imgurl").value;
let img = document.getElementById("preview");

img.src = url;
}

</script>

</head>

<body>

<div class="form-box">

<h2>✏ Edit Movie</h2>

<form method="POST">

<input type="text" name="name" value="<?php echo $row['name']; ?>" required>

<input type="text" id="imgurl" name="image" value="<?php echo $row['image']; ?>" onkeyup="previewURL()" required>

<img id="preview" class="preview" src="<?php echo $row['image']; ?>">

<input type="number" name="price" value="<?php echo $row['price']; ?>" required>

<input type="text" name="rating" value="<?php echo $row['rating']; ?>" required>

<input type="text" name="duration" value="<?php echo $row['duration']; ?>" required>

<input type="text" name="category" value="<?php echo $row['category']; ?>" required>

<input type="text" name="language" value="<?php echo $row['language']; ?>" required>

<input type="text" name="screen" value="<?php echo $row['screen']; ?>" required>

<input type="text" name="trailer" value="<?php echo $row['trailer']; ?>" required>

<button name="update">Update Movie</button>

</form>

</div>

</body>
</html>