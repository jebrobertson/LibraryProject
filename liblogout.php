<?php
//Initialize the session
session_start();

//Unset all of the session variables
$_SESSION = array();

//destroy the session
session_destroy();

//Redirect to the login page
header("location: index.php");
exit;
?>