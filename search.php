<!DOCTYPE HTML>
<html>
<head>
	<?php include 'libconfig.php'; ?>
	<title>Search</title>
	<meta charset='UTF-8'>
        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/blog-home.css" rel="stylesheet">
        <link href="css/searchTable.css" rel="stylesheet">
</head>
<body>
        <?php include 'navbar.php';?>
	<form action = "<?php $_PHP_SELF ?>" method = "GET">
	Title:<input type = "text" name="Title"/>
	Author:<input type = "text" name="Author"/>
	Genre:<select name = "genre">
		<option value = "All">All</option>
		<option value = "Romance">Romance</option>
		<option value = "Biography">Biography</option>
		<option value = "Mystery">Mystery</option>
		<option value = "Thriller">Thriller</option>
		<option value = "SciFi">SciFi</option>
		<option value = "Fantasy">Fantasy</option>
		<option value = "Detective">Detective</option>
	</select>
	<input type = "submit" value = "Search!">
	<br>
	<?php
		if( !empty($_GET["Title"]) || !empty($_GET["Author"])){
			//echo "search db";
			$Title = '%' . $_GET["Title"] . '%';
			$Author = '%' . $_GET["Author"] . '%';
			if($_GET["genre"] == "All"){
				$query = 'SELECT * FROM books WHERE title LIKE $1 and authors LIKE $2 order by title';
				$result = pg_prepare($db, "",$query);
				$result = pg_execute($db, "", array($Title, $Author));
			}else{
				$query = 'SELECT * FROM books WHERE title LIKE $1 and authors LIKE $2 and genre = $3 order by title';
				$result = pg_prepare($db, "", $query);
				$result = pg_execute($db, "", array($Title, $Author, $_GET["genre"]));
			}
			if(!$result){
				echo "result null";
				echo "<br>" .  $query;
			}else{
				//echo "result good";
			}	
	?>

	<table class="searchTable">
		<tr>
			<th>ISBN</th><th>TITLE</th><th>AUTHORS</th>
			<th>GENRE</th><th>YEAR PUBLISHED</th>
		</tr>
		<?php while ($row = pg_fetch_row($result)){
			echo "<tr>";
			echo "<td>$row[0]</td>";
			echo '<td><a href="/books.php?isbn='.$row[0].'">'.$row[3].'</a></td>';
			echo "<td>$row[1]</td>";
			echo "<td>$row[4]</td>";
			echo "<td>$row[2]</td>";
			echo "</tr>";
		}
	} ?>
	</table>
</body>
</html>
