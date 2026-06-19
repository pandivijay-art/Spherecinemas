<?php
session_start();

// database connection
$conn = mysqli_connect("localhost","root","","newproject");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

// form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


// 🔥 STEP 1 — Identify student or user (NEW ADD)
if(strpos($email, ".edu") || strpos($email, ".ac.in")){
    $role = "student";
} else {
    $role = "user";
}



$sql = "INSERT INTO users(name,email,password,role)
VALUES('$username','$email','$password','$role')";

// execute
if(mysqli_query($conn,$sql)){

    
    $_SESSION['username'] = $username;

  
    $_SESSION['role'] = $role;

    
    header("Location: index.html");
    exit();

}else{
    echo "Error: " . mysqli_error($conn);
}
?>