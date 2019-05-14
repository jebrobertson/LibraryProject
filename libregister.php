<?php

//include config file
require_once 'libconfig.php';

//include "header.php";

if(!empty($_POST['add'])){
    //$pass = password_hash('$_POST[password]', 'md5');
    //$pass = "md5('$_POST[$password]')";
    $query = "Insert into users(password, email, rank, firstname, lastname, phonenumber) VALUES($1, $2, 'Default', $3, $4, $5)";
    $result = pg_prepare($db, "", $query);
    $result = pg_execute($db, "", array($_POST['password'], $_POST['username'], $_POST['firstname'], $_POST['lastname'], $_POST['phonenumber']));
    //$query = "INSERT INTO login VALUES('$_POST[username]', '$_POST[password]')";
    //$result = pg_query($query);
    if(!result){
        echo "Error occurred";
    }
    else{
        //echo "success";
    }
}


?>

<html>
    <head>
        <title>Register</title>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendorLogin/bootstrap/cssLogin/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/cssLogin/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendorLogin/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendorLogin/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendorLogin/animsition/cssLogin/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendorLogin/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendorLogin/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="cssLogin/util.css">
	<link rel="stylesheet" type="text/css" href="cssLogin/main.css">
<!--===============================================================================================-->
    
    
     <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">
    </head>
</html>

<body>
<!--
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.html">LibrarEZ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.html">Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="liblogin.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="libregister.php">Register</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

-->
    <div class="limiter">
        <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
            <div class="wrap-login100 p-t-30 p-b-50">
            <span class="login100-form-title p-b-41">Register</span>
            <form class="login100-form validate-form p-b-33 p-t-5" action="libregister.php" method="post">
                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100" type="text" name="username" placeholder="Enter Email">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" name="password" placeholder="Create Password">
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="text" name="firstname" placeholder="Enter Firstname">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>
                 <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="text" name="lastname" placeholder="Enter Lastname">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>
                 <div class="wrap-input100 validate-input" data-validate="Enter username">
                    <input class="input100" type="text" name="phonenumber" placeholder="Enter Phonenumber">
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>
                <div class="container-login100-form-btn m-t-32">
                    <input class="login100-form-btn" type="submit" name="add">
                </div>
                
            </form>
            </div>
        </div>
    </div>
    
    <!--===============================================================================================-->
	<script src="vendorLogin/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendorLogin/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendorLogin/bootstrap/js/popper.js"></script>
	<script src="vendorLogin/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendorLogin/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendorLogin/daterangepicker/moment.min.js"></script>
	<script src="vendorLogin/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendorLogin/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
    <?php include 'navbar.php';?>
    
     <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

