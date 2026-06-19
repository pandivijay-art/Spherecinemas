<?php
session_start();

$conn = mysqli_connect("localhost","root","","newproject");

if(!$conn){
    die("Connection Failed: " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_otp = $_POST['otp'];

    // ✅ 6 digit validation
    if(strlen($user_otp) != 6){
        echo "OTP must be 6 digits ❌";
    }
    else if($user_otp == $_SESSION['otp']){

        // get temp data
        $username = $_SESSION['temp_username'];
        $email = $_SESSION['temp_email'];
        $password = $_SESSION['temp_password'];
        $role = $_SESSION['temp_role'];

        $sql = "INSERT INTO users(name,email,password,role)
        VALUES('$username','$email','$password','$role')";

        if(mysqli_query($conn,$sql)){

            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // ✅ clear OTP (security)
            unset($_SESSION['otp']);

            echo "Verified ✅";

            header("Location: index.html");
            exit();

        } else {
            echo "DB Error ❌";
        }

    } else {
        echo "Wrong OTP ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>OTP Verification</title>
</head>

<body style="text-align:center;margin-top:100px;font-family:Arial;">

<form method="POST">
    <h2>Enter OTP</h2>

    <!-- ✅ 6 digit OTP input -->
    <input type="text" name="otp" maxlength="6"
    pattern="[0-9]{6}"
    placeholder="Enter 6 digit OTP"
    style="padding:10px;font-size:18px;text-align:center;letter-spacing:5px;"
    required>

    <br><br>

    <!-- ✅ verify button (missing before) -->
    <button type="submit" style="padding:10px 20px;">Verify</button>

</form>

</body>
</html>