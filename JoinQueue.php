<!DOCTYPE html>
<html>
<head>
	<?php include 'libconfig.php';?>
	<title>Confirmation</title>
	<meta charset = "UTF-8">
</head>
<body>
	<?php session_start();
	include 'header.php';
	//echo $_POST['isbn'];
	//echo $_SESSION['username'];
	//echo $_SESSION['rank'];
	//echo $_SESSION['userID'];
	if(!isset($_POST['isbn'])){
		header("Location: /index.php");
		die();
	}
	if(!isset($_SESSION['username'])){
		echo "Please log in to rent books!";
		die();
	}

	if(!isset($_POST['confirm'])){?>
		<h1>Are you sure you would like to rent this book?</h1>
		<form action = "<?php $_PHP_SELF ?>" method = "POST">
			<input type = "hidden" name = "isbn" value = "<?php echo $_POST['isbn'];?>">
			<input type = "hidden" name = "confirm" value = "yes">
			<input type = "submit" value = "Rent!">
		</form>
	<?php } else{
		$query = "INSERT INTO Rentals(UserID, ISBN, Status, DateUpdated) Values($1, $2, 'In Queue', current_timestamp)";
		$result = pg_prepare($db, "", $query);
		//echo $query . " " . $_SESSION['userID'] . " " . $_POST['isbn'];
		$result = pg_execute($db, "", array($_SESSION['userID'], $_POST['isbn']));
		if(!$result){
			echo "Something went wrong processing your request. Please try again later!";
		}else{
			echo "You have been successfully added to the queue for this book! You are currently number x in line. Please see your librarian when you are number 1.";
		}
	}?>
		
</body>
</html>

