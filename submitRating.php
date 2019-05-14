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

  </head>

  <body>


    <?php
    include 'navbar.php';
    require_once "libconfig.php";
    if(!isset($_POST['isbn']) || !isset($_POST['rating']) || !isset($_SESSION['userID'])){
    
    ?>

    <h1>Error No rating was submited</h1>
    <a href="index.php">Click here to return home</a>;
    <?php
    }
    else {
        $query = "DELETE FROM ratings WHERE userid=$1 AND isbn=$2";
        $result = pg_prepare($db, "", $query);
        $result = pg_execute($db, "", array($_SESSION['userID'], $_POST['isbn']));
 
        $query = "INSERT INTO ratings VALUES ($1, $2, $3)";
        $result = pg_prepare($db, "", $query);
        $result = pg_execute($db, "", array($_SESSION['userID'], $_POST['isbn'], $_POST['rating']));
        if($result){
        ?>
          
    <h1>Thank you the rating was successful!</h1>
    <a href="index.php">Click here to return home</a>;

        <?php
        }
        else {
    ?>
    
    <h1>Error Failure to enter Rating into the database</h1>
    <a href="index.php">Click here to return home</a>;
    
    <?php
           echo '<p>'.pg_last_error($db).'</p>';
       }
    }
    ?>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
