<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="image/x-icon" href="logo.png" />
    <title>DB Control Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
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


            <form action="index.php" method="post" class="login100-form marginchangepassword">
					<span class="login100-form-title">
						Member Login
					</span>

                <div class="wrap-input100">
                    <input type="text" id="username" name="username" class="form-control input100" placeholder="Username">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100" data-validate="Password is required">
                    <input type="password" id="password" name="password" class="form-control input100" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>
                <div class="container-login100-form-btn">
                    <input type="submit" name="login" value="Login" class="login100-form-btn">

                </div>
                <div class="text-center p-t-12">
						<span class="txt1">
							Having
						</span>
                    <a class="txt2" href="discord.php">
                        Issues?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="register.php">
                        Create your Account
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

if(isset($_POST['login'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;

    $sql = "SELECT id, username, password FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user === false){

        echo '<script>alert("Couldnt find a user with that username");</script>';
    } else{


        $validPassword = password_verify($passwordAttempt, $user['password']);


        if($validPassword){
            $_SESSION['id'] = $user['id'];
            $_SESSION['ip'] = $user['ip'];
            $_SESSION['timestamp'] = $user['timestamp'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['token'] = $user['token'];

            $userna = $_SESSION['username'];
            $query = "INSERT INTO log (username, `action`, old, new) VALUES ('$userna', 'Login', '-', '-')";
            $prepare = $pdo->prepare($query);
            $prepare->execute();
            header('Location:home.php');
            exit;

        } else{

            echo '<script>alert("Incorrect Password!");</script>';
        }
    }

}
?>
<!--===============================================================================================-->
<script src="ExtraCSS/vendor/jquery/jquery-3.2.1.min.js"></script>
<script src="ExtraCSS/vendor/bootstrap/js/popper.js"></script>
<script src="ExtraCSS/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="ExtraCSS/vendor/select2/select2.min.js"></script>
<script src="ExtraCSS/vendor/tilt/tilt.jquery.min.js"></script>
<script src="ExtraCSS/js/main.js"></script>
<!--===============================================================================================-->


</body>
</html>