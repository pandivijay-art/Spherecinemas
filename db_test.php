<?php
$conn = new mysqli("localhost", "root", "", "movie_site");

if ($conn->connect_error) {
  die("DB Connection Failed: " . $conn->connect_error);
}

echo "Database Connected Successfully!";
?>
