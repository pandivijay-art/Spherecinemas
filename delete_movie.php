<?php
include "db.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM movies WHERE id=$id");

header("Location: admin_dashboard.php?page=manage");
?>