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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">LibrarEZ</a>
        <?php
          session_start();
          if(isset($_SESSION['username'])){
          ?>
        <a class="navbar-brand" href="#">Welcome <?php echo $_SESSION['username'] ?></a>
          <?php
          }
              ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="search.php">Search</a>
            </li>
              <?php
              
              if($_SESSION['rank'] == 'Admin' || $_SESSION['rank'] == 'Librarian'){
              ?>
              <li class="nav-item">
              <a class="nav-link" href="viewQueue.php">View Queue</a>
            </li>
              <?php
              }
                ?>
              
            <?php
              
              if(isset($_SESSION['username'])){           
              ?>
            <li class="nav-item">
              <a class="nav-link" href="liblogout.php">Logout</a>
            </li>
            <?php
              }
              else{
             ?>
               <li class="nav-item">
              <a class="nav-link" href="liblogin.php">Login</a>
            </li>
               <li class="nav-item">
              <a class="nav-link" href="libregister.php">Register</a>
            </li>
            <?php
              }
              ?>
          </ul>
        </div>
      </div>
    </nav>

  

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
