<!DOCTYPE html>
<html lang="en">
<head>


    <link rel="shortcut icon" type="image/x-icon" href="logo.png" />
  <title>DB Control Panel</title>

  <!-- Bootstrap core CSS -->
    <link href="https://admin.tomhartog.nl/dist/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://admin.tomhartog.nl/dist/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://admin.tomhartog.nl/dist/assets/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css.css" rel="stylesheet" type="text/css">


</head>



  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary static-top">
    <div class="container" >
        <?php
        //home.php
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
            <a class="nav-link" href="home.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
            <div class="dropdown">
          <li class="nav-item">
            <span class="nav-link" href="">Settings</span>
            
              <div class="dropdown-content bg-secondary">
                  <a class="nav-link" href="changepassword.php">Change Password</a>
                  <a class="nav-link" href="">Change Username</a>
		  <a class="nav-link" href="admin.php">Admin Panel</a>
                  <a class="nav-link" href="logout.php">Logout</a>
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


          <button class="btn btn-outline-success my-2 my-sm-0 " type="submit" placeholder="Add Note" value="AddNote" id="AddNote" name="AddNote">Add Note</button>
          <input class="form-control mr-sm-2 " type="text" placeholder="ID" aria-label="ID" name="ID" id="ID">
          <input class="form-control mr-sm-2 " type="text" placeholder="Note..." aria-label="Add_Note" name="Add_Note" id="Add_Note">

  </form>
  <?php
  require 'connect.php';



  ?>
  </div>

  <br class="table-dark">


  <table class="table table-dark table-bordered">
      <thead>
      <tr>
          <th>id</th>
          <th>IP</th>
          <th>Time</th>
          <th>Region</th>
          <th>City</th>
          <th>Country</th>
          <th>Notes</th>
      </tr>
      </thead>
      <tbody>
      <?php

      $result = 'SELECT access FROM users WHERE username ="' . $_SESSION["username"] . '"';
      foreach ($pdo->query($result) as $answer) {
          $access = $answer['access'];
          if ($access == "TRUE") {

              if(isset($_POST['search'])) {
                  $searchfor = $_POST['Search_Keyword'];
                  $sql = 'SELECT id, ip, region, city, country, notes, timestamp FROM ips WHERE id = "'.$searchfor.'" OR ip = "'.$searchfor.'" OR region = "'.$searchfor.'" OR city = "'.$searchfor.'" OR country = "'.$searchfor.'" OR notes = "'.$searchfor.'"  ';
                  foreach ($pdo->query($sql) as $row) {
                      echo "<tr><td>" . $row["id"] . "</td><td>" . $row["ip"] . "</td><td >"
                          . $row["timestamp"] . "</td><td>"
                          . $row["region"] . "</td><td>"
                          . $row["city"] . "</td><td>"
                          . $row["country"] . "</td><td>". $row["notes"] ."</td>";
                  }
              }
              if(isset($_POST['AddNote'])) {

                  $userid = $_POST['ID'];
                  $addnote = $_POST['Add_Note'];
                  if($userid === "") {
                      echo "<script>alert('Please fill in the ID and the notes field.');</script>";
                      $sqlnoid = 'SELECT id, ip, timestamp, region, city, country, notes FROM ips';
                      foreach ($pdo->query($sqlnoid) as $tablerow) {
                          echo "<tr><td >" . $tablerow["id"] . "</td><td>" . $tablerow["ip"] . "</td><td>"
                              . $tablerow["timestamp"] . "</td><td>"
                              . $tablerow["region"] . "</td><td>"
                              . $tablerow["city"] . "</td><td>"
                              . $tablerow["country"] . "</td><td>". $tablerow["notes"] ."</td>";
                      }
                  } else if($addnote === "") {
                      echo "<script>alert('Please fill in the ID and the notes field.');</script>";
                       $sqlnonote = 'SELECT id, ip, timestamp, region, city, country, notes FROM ips';
                       foreach ($pdo->query($sqlnonote) as $tablerows) {
                           echo "<tr><td >" . $tablerows["id"] . "</td><td>" . $tablerows["ip"] . "</td><td>"
                               . $tablerows["timestamp"] . "</td><td>"
                               . $tablerows["region"] . "</td><td>"
                               . $tablerows["city"] . "</td><td>"
                               . $tablerows["country"] . "</td><td>". $tablerows["notes"] ."</td>";
                       }

                  } else {
                      $sqllookfornote = "SELECT notes FROM ips WHERE id = '$userid' ";
                      $exe = $pdo->prepare($sqllookfornote);
                      $exe->execute();
                      $return = $exe->fetch(PDO::FETCH_ASSOC);
                      
                      $old = $return['notes'];
                      $username = $_SESSION["username"];
                      $sqlinsertnote = "INSERT INTO log (username, `action`, old, new) VALUES ('$username', 'Update Note','$old', '$addnote') ";
                      $stmttt = $pdo->prepare($sqlinsertnote);
                      $stmttt->execute();
                      $sqlnote = $pdo->exec("UPDATE ips SET notes = '$addnote' WHERE id = '$userid'");
                    if($sqlnote) {

                        $filltable = 'SELECT id, ip, timestamp, region, city, country, notes FROM ips';
                        foreach ($pdo->query($filltable) as $table) {
                            echo "<tr><td >" . $table["id"] . "</td><td>" . $table["ip"] . "</td><td>"
                                . $table["timestamp"] . "</td><td>"
                                . $table["region"] . "</td><td>"
                                . $table["city"] . "</td><td>"
                                . $table["country"] . "</td><td>" . $table["notes"] . "</td>";
                        }
                    }
                   }
              } else {
                  $query = 'SELECT id, ip, timestamp, region, city, country, notes FROM ips';
                  foreach ($pdo->query($query) as $inf) {
                      echo "<tr><td >" . $inf["id"] . "</td><td>" . $inf["ip"] . "</td><td>"
                          . $inf["timestamp"] . "</td><td>"
                          . $inf["region"] . "</td><td>"
                          . $inf["city"] . "</td><td>"
                          . $inf["country"] . "</td><td>". $inf["notes"] ."</td>";
                  }
              }
          } else {
              header("location:NoAccess.php");
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


  <!-- Bootstrap core JavaScript -->
  <script src="https://admin.tomhartog.nl/dist/assets/js/jqeury.slim.min.js"></script>
  <script src="https://admin.tomhartog.nl/dist/assets/js/bootstrap.bundle.min.js"></script>


</body>

</html>
