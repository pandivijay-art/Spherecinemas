<?php
session_start();

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $admin_user = "admin";
    $admin_pass = "1234";

    if($username === $admin_user && $password === $admin_pass){
        
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();

    }else{
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<style>


body{
margin:0;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
font-family: Arial, Helvetica, sans-serif;
background:linear-gradient(135deg,#000000,#1a1a1a);
color:white;
}


.login-box{
background:#111;
padding:40px;
border-radius:15px;
width:320px;
box-shadow:0 0 30px rgba(255,46,99,0.3);
text-align:center;
}


.login-box h2{
color:#ff2e63;
margin-bottom:20px;
}


input{
width:100%;
padding:12px;
margin:10px 0;
border:none;
border-radius:8px;
background:#222;
color:white;
}

button{
width:100%;
padding:12px;
margin-top:15px;
border:none;
border-radius:8px;
background:#ff2e63;
color:white;
font-size:16px;
cursor:pointer;
}

button:hover{
background:#e61e50;
}


.error{
color:red;
margin-top:10px;
}

</style>
</head>

<body>

<div class="login-box">

<h2>🎬 Admin Login</h2>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

</form>

<p class="error"><?php echo $error; ?></p>

</div>

</body>
</html>