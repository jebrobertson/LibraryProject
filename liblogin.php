<?php

//Include config file
require_once 'libconfig.php';

//include "header.php";


//Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";


//Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
/*
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username";
    }
    else{
        $username = trim($_POST["username"]);
    }
    
    //check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    }
    else{
        $password = trim($_POST['password']);
    }
*/
    //validate credentials
    if(empty($username_err) && empty($password_err)){
        //try to prevent SQL-Injection
        //$hashpassword = hash('md5', $2);
        
	//USE THIS WHEN READY
	$query = "SELECT * FROM users where email = $1";
	$result = pg_prepare($db, "", $query);
	$result = pg_execute($db, "", array($_POST['username']));

	
	//$query = 'SELECT * FROM login WHERE username=$1 and password = ($2)';
        //$e = md5($2);
        //$result = pg_query_params($db, $query, array($_POST["username"], $_POST["password"]));
        //$hash = pg_query($db, "SELECT password FROM login WHERE username='$_POST[username]'");
        //$arr = pg_fetch_array($hash);
        //echo $arr[0];
    
        //$result = pg_prepare($db, "", $query);
        //$result = pg_execute($db, "", array($_POST["username"], $_POST["password"]));
        
        if(!result){
            echo "result null";
        }
        else{
            //echo "result good";
            //echo $query;
            //echo $e;
            $rows = pg_num_rows($result);
            //echo $rows . "row(s) returned.\n";
        }
        $arr = pg_fetch_assoc($result);
        //echo $arr['password']."\n";
        //echo $_POST['password'];
        if(!password_verify($_POST['password'],$arr['password'])){
            echo "Username or Password does not exist.\n Please Try Again.\n";
            //header('Refresh: 10; URL=http://ec2-3-94-120-99.compute-1.amazonaws.com');
        }
        else {
            //save username to session
            session_start();
		$_SESSION['userID'] = $arr['userid'];
		$_SESSION['rank'] = $arr['rank'];
		$_SESSION['username'] = $arr['email'];
            	
		header("location: index.php");
	}
    }


  //close connection
    pg_close($dbconn);

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>LibrarEZ Login</title>
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
              <a class="nav-link" href="index.php">Home
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
				<span class="login100-form-title p-b-41">
					Login
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Email">
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
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
</html>
