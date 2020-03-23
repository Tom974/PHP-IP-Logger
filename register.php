<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/x-icon" href="logo.png" />
    <title>DB Control Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="ExtraCSS/images/icons/favicon.ico">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/css/util.css">
    <link rel="stylesheet" type="text/css" href="ExtraCSS/css/main.css">
    <link rel="stylesheet" type="text/css" href="css.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form action="register.php" method="post" class="login100-form marginchangepassword">
		<span class="login100-form-title">
		 Create Account
		</span>

                <div class="wrap-input100 ">
                    <input type="text" id="username" name="username" class="form-control input100" placeholder="Username">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
			<i class="fa fa-user" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 " data-validate = "Password is required">
                    <input type="password" id="password" name="password" class="form-control input100" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
			<i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="container-login100-form-btn">
                    <input type="submit" name="register" id="register" value="Register" class="login100-form-btn">

                </div>
                <div class="text-center p-t-12">
			<span class="txt1">
			 Having
			</span>
                    <a class="txt2" href="discord.php">
                        issues?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="index.php">
                        Go back to login screen
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

session_start();

require 'lib/password.php';
require 'connect.php';

if(isset($_POST['register'])){

    $token = rand();
    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
	
    $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row['num'] > 0){
        echo '<script>alert("That username already exists! Try another one!");</script>';
    } else {

    $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));

    $sql = "INSERT INTO users (username, password, token) VALUES (:username, :password, :token)";
    $stmt = $pdo->prepare($sql);

    //Bind our variables.
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $passwordHash);
    $stmt->bindValue(':token', $token);

    $result = $stmt->execute();

     if($result){

        echo '<script>alert("Your account has been successfully created!");</script>';
     }
    }
}
?>
