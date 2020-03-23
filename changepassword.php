<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/x-icon" href="logo.png" />
    <title>DB Control Panel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="lib/favicon.ico">
    <link rel="stylesheet" type="text/css" href="Elib/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="lib/animate.css">
    <link rel="stylesheet" type="text/css" href="lib/animate.css">
    <link rel="stylesheet" type="text/css" href="lib/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="lib/select2.min.css">
    <link rel="stylesheet" type="text/css" href="lib/util.css">
    <link rel="stylesheet" type="text/css" href="lib/main.css">
    <link rel="stylesheet" type="text/css" href="lib/css.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">

            <form action="changepassword.php" method="post" class="login100-form marginchangepassword">
					<span class="login100-form-title">
						Change Password
					</span>

                <div class="wrap-input100 " data-validate = "Old Password is required">
                    <input type="password" name="OldPass" id="OldPass" class="form-control input100" placeholder="Old Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 " data-validate = "Password is required">
                    <input type="password" name="NewPassword" id="NewPassword" class="form-control input100" placeholder="New Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="wrap-input100 " data-validate = "Token is required">
                    <input type="text" name="token" id="token" class="form-control input100" placeholder="Token">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
                    </span>
                </div>

                <div class="container-login100-form-btn">

                    <input type="submit" name="Change" value="Change" class="login100-form-btn">

                </div>
                <div class="text-center p-t-12">

                    <a class="txt2" href="register.php">
                        Having problems?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="discord.php">
                        Don't have a token?
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
session_start();
if(!isset($_SESSION["username"]))
{
    header("location:index.php");
}
require 'connect.php';

if(isset($_POST['Change'])) {


    $sql = 'SELECT * FROM users WHERE username ="'.$_SESSION['username'].'" ';
    foreach ($pdo->query($sql) as $result) {
        $PasswordResult = $result['password'];
        $UsernameResult = $result['username'];
        $token = $result['token'];

        $TokenFrm = $_POST['token'];
        $OldPass = $_POST['OldPass'];

        $validPassword = password_verify($OldPass, $result['password']);

        if ($token == $TokenFrm && $validPassword) {

            $NewPasswrd = $_POST['NewPassword'];
            $PassHash = password_hash($NewPasswrd, PASSWORD_BCRYPT, array("cost" => 12));
            $answer = $pdo->exec('UPDATE users SET `password` = "'.$PassHash.'" WHERE username ="'.$_SESSION['username'].'" ');


                echo '<script>alert("Succesfully changed your password!"); window.location = "index.php";</script> ';



        } else {
            echo '<script>alert("Records did not match.");</script>';
        }
    }
}
?>



<!--===============================================================================================-->
<script src="lib/jquery-3.2.1.min.js"></script>
<script src="lib/popper.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="lib/select2.min.js"></script>
<script src="lib/tilt.jquery.min.js"></script>
<script src="lib/main.js"></script>
<!--===============================================================================================-->


</body>
</html>
