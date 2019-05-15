<?php
session_start();
if(!isset($_SESSION['rank']) || $_SESSION['rank'] =="Default"){
     echo "Access Denied";
     exit();
}
?>

<!DOCTYPE html>
<html lang='en'>
    <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LibrarEZ</title>
      <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/blog-home.css" rel="stylesheet">
    <link href="css/bookHolder.css" rel="stylesheet">
    </head>
    <body>
    <?php include 'navbar.php';
    require_once 'libconfig.php';
    if(isset($_POST['isbn'])){
      $query = "INSERT INTO books (title, isbn, authors, yearpublished, genre) VALUES ($1, $2, $3, $4, $5)";
      $result = pg_prepare($db, "", $query);
      $result = pg_execute($db, "", array($_POST['title'], $_POST['isbn'], $_POST['author'], $_POST['year'], $_POST['genre']));
      if($result)
        echo "Book added!";
      else
        echo "Book Failed to add.";
      
      $query = "INSERT INTO bxbooks (booktitle, isbn, bookauthor, yearofpublication) VALUES ($1, $2, $3, $4)";
      $result = pg_prepare($db, "", $query);
      $result = pg_execute($db, "", array($_POST['title'], $_POST['isbn'], $_POST['author'], $_POST['year']));
      }
     ?>
    <form action="" method="POST">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
      <label for="isbn">ISBN</label>
        <input type="text" class="form-control" id="isbn" name="isbn">
      </div>
      <div class="form-group">
      <label for="author">author</label>
        <input type="text" class="form-control" id="author" name="author">
      </div>
      <div class="form-group">
      <label for="year">Year Published</label>
        <input type="text" class="form-control" id="year" name="year">
      </div>
      <div class="form-group">
      <label for="genre">Genre</label>
        <input type="text" class="form-control" id="genre" name="genre">
      </div>
      <button type="submit" class="btn btn-primary">Add book</button>
    </form>
        </body>

<html>
