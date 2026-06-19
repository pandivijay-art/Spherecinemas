<?php
$conn = new mysqli("localhost", "root", "", "movie_site");

if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "Login Success! Welcome to cinemas, " . htmlspecialchars($username);
} else {
    echo "Invalid Username or Password!";
}

$conn->close();
?>
