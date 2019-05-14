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
    <link href="css/searchTable.css" rel="stylesheet">
  </head>

  <body>
    <?php include('navbar.php');?>
    <!-- Navigation
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
   </nav> -->
   <?php
   
       function printResults($result){
         while($line = pg_fetch_array($result)){
           echo '<tr>';
           echo '<td>'.$line[1].'</td>';
           echo '<td>'.$line[0].'</td>';
           echo '<td>'.$line[3].'</td>';
	   echo '<td>'.$line[5].'</td>';
	   echo '<td>'.$line[6].'</td>';
	   echo '<td>'.$line[7].'</td>';
           echo '<td>'.$line[4].'</td>';
           echo '<td><form action="" method="POST">';
           if(strcmp($line[3], "Rented Out") == 0){
               echo '<input type="submit" name="action" value="Return">';
               echo '<input type="submit" name="action" value="Delete">';
           }
           else{
               echo '<input type="submit" name="action" value="Checkout">';
               echo '<input type="submit" name="action" value="Delete">';
           }

           echo '<input type="hidden" name="isbnChange" value="'.$line[1].'">';
           echo '<input type="hidden" name="useridChange" value="'.$line[0].'">';
           if(isset($_POST['name']))
               echo '<input type="hidden" name="name" value="'.$_POST['name'].'">';
           if(isset($_POST['isbn']))
               echo '<input type="hidden" name="isbn" value="'.$_POST['isbn'].'">';
               
           echo '</form></td>';
           echo '</tr>';
         }
       }
       session_start();
       if(!isset($_SESSION['rank']) || $_SESSION['rank']=="Default"){
           echo "Access Denied"; 

       }
       else{
   ?>
   <form action="" method="POST">
     <h3>Search for user or ISBN to Edit Queue</h3>
     Name: <input type="text" name="name"> UserID: <input type="text" name="userid"> ISBN: <input type="text" name="isbn"> 
     <input type="submit" value="search">
   </form>
   <?php
                   
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
           require_once 'libconfig.php';
           if(isset($_POST['action'])){
               if($_POST['action']=="Delete"){
                   $query = "DELETE FROM rentals WHERE userid=$1 AND isbn=$2";
                   $result = pg_prepare($db, "", $query);
                   $result = pg_execute($db, "", array($_POST['useridChange'], $_POST['isbnChange']));
                   if($result)
                       echo "Record Successfully deleted";
               }
               else if($_POST['action'] == "Return"){
                   
                   $query = "UPDATE rentals SET status='Returned', dateupdated=current_timestamp WHERE userid=$1 AND isbn=$2";
                   $result = pg_prepare($db, "", $query);
                   $result = pg_execute($db, "", array($_POST['useridChange'], $_POST['isbnChange']));
                   if($result)
                       echo "Record successfully updated";
               } else if($_POST['action'] == "Checkout"){
                   $query = "UPDATE rentals SET status='Rented Out',dateupdated=current_timestamp WHERE userid=$1 AND isbn=$2";
                   $result = pg_prepare($db, "", $query);
                   $result = pg_execute($db, "", array($_POST['useridChange'], $_POST['isbnChange']));
                   if($result)
                       echo "Record successfully updated!";
               }
           }
           echo '<table class="searchTable">';
           echo '<tr>';
           echo '<th>ISBN</th>';
           echo '<th>Userid</th>';
           echo '<th>Status</th>';
	   echo '<th>First name</th>';
	   echo '<th>Last Name</th>';
	   echo '<th>Email</th>';
           echo '<th>Day updated</th>';
           echo '<th>Action</th>';
           echo '</tr>';

           if(isset($_POST['name']) /*&& !isset($_POST['isbn']*/){
              $query = "SELECT Rentals.*, users.firstname, users.lastname, users.email FROM rentals, users WHERE users.firstname = $1 and rentals.status<>'Returned' and rentals.userid = users.userid";
              $nameResult = pg_prepare($db, "", $query);
              $nameResult = pg_execute($db, "", array($_POST['name']));
              printResults($nameResult);
           }
           if(isset($_POST['userid']) /*&& !isset($_POST['isbn']*/){
              $query = "SELECT Rentals.*, users.firstname, users.lastname, users.email FROM rentals, users WHERE rentals.userid=$1 and rentals.status<>'Returned' and rentals.userid = users.userid";
              $nameResult = pg_prepare($db, "", $query);
              $nameResult = pg_execute($db, "", array($_POST['userid']));
              printResults($nameResult);
           }
           if(isset($_POST['isbn'])){
              $query = "SELECT Rentals.*, users.firstname, users.lastname, users.email FROM rentals,users WHERE rentals.isbn=$1 and rentals.status<>'Returned' and rentals.userid = users.userid ORDER BY rentals.dateupdated";
              $isbnResult = pg_prepare($db, "", $query);
              $isbnResult = pg_execute($db, "", array($_POST['isbn']));
              printResults($isbnResult);
	      
           }
           echo '</table>';
       }
     }
   ?>
   <!-- Footer
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
      </div>
       /.container
    </footer>
-->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
