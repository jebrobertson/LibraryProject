
<!DOCTYPE html>
<html lang="en">

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
     <?php include 'navbar.php'?>
    <!--
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">LibrarEZ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Movies</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="liblogin.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    -->
     <?php
     if(!isset($_GET['isbn'])){
        echo "<h1>Sorry there is no book selected<h1>";
        echo '<a href="index.php">Return to home page</a>';
     }
     else{
         session_start();
         require_once 'libconfig.php';
         $query = 'SELECT booktitle, bookauthor, imageurll FROM bxbooks WHERE isbn=$1';
         $result = pg_prepare($db, "", $query);
         $result = pg_execute($db, "", array($_GET['isbn']));
         
         if(!$result || pg_num_rows($result) < 1 ){
             echo "<h1>Sorry there is no book selected<h1>";
             echo '<a href="index.php">Return to home page</a>';
         }
         else{
             while($book = pg_fetch_array($result)){
                 echo '<div class="bookHolder" > ';
                 echo '<img class="bookImg" src="'.$book[2].' alt="'.$book[0].'">';
                 echo '<div class="bookInfo">';
                 echo '<p class="bookTitle">'.$book[0].'</p>';
                 echo '<p class="bookAuthor"> by '.$book[1].'</p>';
                 echo '</div>';
                 echo '</div>';
             }
             if(isset($_SESSION['username'])){
  	?>
          <hr>
	<?php
        //check logged in users current rental status for the chosen book, if they are in queue or rented out already, display that, else allow them to rent the book
        $query = "Select Status from rentals where UserID = $1 and ISBN = $2 and Status <> 'Returned'";
	$result = pg_prepare($db, "", $query);
	$result = pg_execute($db, "", array($_SESSION['userID'], $_GET['isbn']));
	if(!result || pg_num_rows($result) < 1){?>
	  <form action = "/JoinQueue.php" method = "POST">
		<?php $isbn = $_GET['isbn']; ?> 
	  	<input type="hidden" name="isbn" value="<?php echo $isbn;?>">
		<input type="submit" value="Rent this Book!">
		
	  </form>
	<?php }else{
		while($row = pg_fetch_array($result)){
			echo "Your current status for this book: $row[0]";
			//if user is in queue, find and display how many users are ahead of them
			if($row[0] == 'In Queue'){
				$query = "Select count(*) from rentals where isbn = $1 and Status = 'In Queue' and dateUpdated < (Select dateUpdated from rentals where isbn = $2 and UserID = $3)";
				$result2 = pg_prepare($db, "", $query);
				$result2 = pg_execute($db, "", array($_GET['isbn'], $_GET['isbn'], $_SESSION['UserID']));
				if($result2){
					while($row2 = pg_fetch_array($result2)){
					echo "<br>There are currently $row2[0] people ahead of you in queue for this book.";
					}
				}
			} 
		}
	}?>
	  <hr>
          <form action="/submitRating.php" method="POST"> 
              <h3>Rate this Book!</h3>
  <?php 
                 for($i=1; $i<=10; $i++)
                 {
                     echo $i.' <input type="radio" name="rating" value="'.$i.'">'."\t";
                 }
                 echo '</pre>';
                 echo '<input type="hidden" name="isbn" value="'.$_GET['isbn'].'" />';
   ?> 
              <br> 
             <input type="submit" value="Submit">
         </form>

   <?php
            }
        }
     }
    ?>
     <!-- Footer 
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
     
    </footer>
-->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>

