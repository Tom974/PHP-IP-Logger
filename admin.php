<!DOCTYPE html>
<html lang="en">
<head>


    <link rel="shortcut icon" type="image/x-icon" href="logo.png" />
    <title>DB Control Panel</title>

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



<nav class="navbar navbar-expand-lg navbar-dark bg-secondary static-top">
    <div class="container" >
        <?php
        //Admin.php
        session_start();
        if(!isset($_SESSION["username"]))
        {
            header("location:index.php");

        }
        echo '<a class="navbar-brand">Welcome, '.$_SESSION["username"].'!</a>';

        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link " href="home.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <div class="dropdown">
                    <li class="nav-item">
                        <span class="nav-link" href="">Settings</span>

                        <div class="dropdown-content bg-secondary">
                            <p href="changepassword.php">Change Password</p>
                            <p href="">Change Username</p>
                            <p href="logout.php">Logout</p>
                        </div>

                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>

</head>

<br class="table-dark">
<br class="table-dark">
<body class="table-dark">
<!-- Page Content -->

<form class="form-inline my-2 my-lg-0 table-dark" method="post">
    <div class="topnav">
        <button class="btn btn-outline-success my-2 my-sm-0 " type="submit" placeholder="Search" value="Search" id="search" name="search">Search</button>
        <input class="form-control mr-sm-2 " type="search" placeholder="Search..." aria-label="Search" name="Search_Keyword" id="Search_Keyword">


        <button class="btn btn-outline-danger my-2 my-sm-0 " type="submit" placeholder="Delete" value="Delete" id="Delete" name="Delete">Delete</button>
        <input class="form-control mr-sm-2 " type="text" placeholder="ID" aria-label="ID" name="ID" id="ID">

</form>

</div>

<br class="table-dark">


<table class="table table-dark table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Time</th>
        <th>Username</th>
        <th>Action</th>
        <th>Old</th>
        <th>New</th>
    </tr>
    </thead>
    <tbody>
    <?php
    require 'connect.php';
    $adminaccess = 'SELECT admin, access FROM users WHERE username ="' . $_SESSION["username"] . '"';
    foreach ($pdo->query($adminaccess) as $row) {
        $admin = $row['admin'];
        $access = $row['access'];
        if ($admin == "TRUE" && $access == "TRUE") {

            if(isset($_POST['Delete'])) {

                $userid = $_POST['ID'];
                $sqldelete = $pdo->exec("DELETE FROM `log` WHERE (`id` = '$userid');");
                $querytwo = 'SELECT id, `timestamp`, username, `action`, old, new FROM log ORDER BY `timestamp` DESC;';
                foreach ($pdo->query($querytwo) as $infa) {
                    echo "<tr><td >" . $infa["id"] . "</td><td>" . $infa["timestamp"] . "</td><td>" . $infa["username"] . "</td><td>" . $infa["action"] . "</td><td>" . $infa["old"] . "</td><td>" . $infa["new"] . "</td>";
                }

            } else {
                $query = 'SELECT id, `timestamp`, username, `action`, old, new FROM log ORDER BY `timestamp` DESC;';
                foreach ($pdo->query($query) as $inf) {
                    echo "<tr><td >" . $inf["id"] . "</td><td>" . $inf["timestamp"] . "</td><td>" . $inf["username"] . "</td><td>" . $inf["action"] . "</td><td>" . $inf["old"] . "</td><td>" . $inf["new"] . "</td>";
                }

            }


        } else {
            header("location:NoAdminAccess.php");
        }
    }


    ?>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>



<script src="lib/jqeury.slim.min.js"></script>
<script src="lib/bootstrap.bundle.min.js"></script>


</body>
</html>
