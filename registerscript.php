<?php
	require_once 'libconfig.php';
	for($x = 12; $x < 278860; $x++){
		$query = "INSERT INTO users(email, password) values('reee', 'reee')";
		$result = pg_query($query);
		echo $x . " ";
	}
?>
