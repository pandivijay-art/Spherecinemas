<?php
include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Movies</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#0f0f0f;
    color:white;
}


h2{
    text-align:center;
    padding:20px;
    color:#ff2e63;
}

.table-box{
    width:90%;
    margin:30px auto;
    background:rgba(255,255,255,0.05);
    border-radius:15px;
    padding:20px;
    box-shadow:0 0 20px rgba(255,46,99,0.2);
    backdrop-filter:blur(10px);
}


table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:10px;
}


th{
    background:#ff2e63;
    padding:15px;
    font-size:16px;
}


td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #333;
}


tr:hover{
    background:#1a1a1a;
    transition:0.3s;
}

/* IMAGE */
img{
    width:70px;
    height:90px;
    object-fit:cover;
    border-radius:8px;
}

/* BUTTONS */
.action-btn{
    padding:6px 12px;
    border-radius:5px;
    text-decoration:none;
    font-size:14px;
}

.edit{
    background:#3498db;
    color:white;
}

.delete{
    background:#e74c3c;
    color:white;
}


.edit:hover{
    background:#5dade2;
}

.delete:hover{
    background:#ff5c5c;
}


.empty{
    text-align:center;
    padding:20px;
    color:#aaa;
}

</style>
</head>

<body>

<h2>🎬 Manage Movies</h2>

<div class="table-box">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Poster</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php

$result = mysqli_query($conn,"SELECT * FROM movies");

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){
?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['name']; ?></td>

<td>
<img src="<?php echo $row['image']; ?>">
</td>

<td>₹<?php echo $row['price']; ?></td>

<td>
<a class="action-btn edit" href="edit_movie.php?id=<?php echo $row['id']; ?>">✏ Edit</a>

<a class="action-btn delete" href="delete_movie.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this movie?')">❌ Delete</a>
</td>

</tr>

<?php
}
}else{
    echo "<tr><td colspan='5' class='empty'>No Movies Found 😢</td></tr>";
}
?>

</table>

</div>

</body>
</html>