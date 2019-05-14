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
  <?php include 'navbar.php'; ?>
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
    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

          <h1 class="my-4">About LibrarEZ
            <small>Our Story</small>
          </h1>

          <!-- Blog Post -->
          <div class="card mb-4">
            <img class="card-img-top" src="../books.png" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">How We Started</h2>
              <p class="card-text">LibrarEZ was created by three students at the University of Missouri-Columbia for a capstone project. The founders Jeb, Brighton and Akshay had a vision to revitalize library software systems since many smaller libraries and bookstores are struggling to stay afloat in this digital era.</p>
            <!--  <a href="#" class="btn btn-primary">Read More &rarr;</a> -->
            </div>
            
          </div>

          
          <div class="card mb-4">
            <img class="card-img-top" src="../matdecomp.png" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">How It Works</h2>
              <p class="card-text">This website is hosted on a EC2 instance through Amazon Web Services and continuously interacts with a PostgreSQL Database hosted on Amazon RDS. The powerful recommendation system is built on a efficient and effective machine learning algorithm using matrix decomposition.</p>
              <!-- <a href="#" class="btn btn-primary">Read More &rarr;</a> -->
            </div>
<!--
            <div class="card-footer text-muted">
              Posted on January 1, 2017 by
              <a href="#">Start Bootstrap</a>
            </div>
-->
          </div>

          
          <div class="card mb-4">
            <img class="card-img-top" src="../System Architecture.JPG" alt="Card image cap">
            <div class="card-body">
              <h2 class="card-title">System Architecture</h2>
              <p class="card-text">Special Thanks to Amazon Web Services!</p>
              
            </div>
          </div>

         
 

        </div>



        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- 
          <div class="card my-4">
            <h5 class="card-header">Search</h5>
            <div class="card-body">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button class="btn btn-secondary" type="button">Go!</button>
                </span>
              </div>
            </div>
          </div>
-->
          <!-- 
          <div class="card my-4">
            <h5 class="card-header">Genres</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="#">Science Fiction</a>
                    </li>
                    <li>
                      <a href="#">Satire</a>
                    </li>
                    <li>
                      <a href="#">Drama</a>
                    </li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul class="list-unstyled mb-0">
                    <li>
                      <a href="#">Action & Adventure</a>
                    </li>
                    <li>
                      <a href="#">Romance</a>
                    </li>
                    <li>
                      <a href="#">Mystery</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
-->
          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Recommended</h5>
            <div class="card-body" style="font-size: 8pt;">             
              <?php
              session_start();
              if(!isset($_SESSION['userID'])){
                  echo '<p>If you log in this will be where your recommended feed is!</p>';
              }
              else{
                  require_once 'libconfig.php';
                  $query = "SELECT (factoredusers.feature1 * factoredbooks.feature1 + factoredusers.feature2 * factoredbooks.feature2) AS estimate, isbn  FROM factoredusers, factoredbooks WHERE userid = $1 ORDER BY estimate DESC LIMIT 10";
                  $result = pg_prepare($db, "", $query);
                  $result = pg_execute($db, "", array($_SESSION['userID']));
                  $first = true;
                  while ($line = pg_fetch_array($result)){
                     $query = "SELECT booktitle, bookauthor, imageurlm FROM bxbooks WHERE isbn =$1";
                     $books = pg_prepare($db, "", $query);
                     $books = pg_execute($db, "", array($line[1]));
                     while($book = pg_fetch_array($books)){
                         if(!($first)){
                            echo "<hr>";
                         }
                         echo '<a href="/books.php?isbn='.$line[1].'" style="text-decoration: none; color: black;">';
                         echo '<div class="bookHolder">';
                         echo '<img class="bookImg" src="' . $book[2] . '" alt="' . $book[0] . '" ></img>';
                         echo '<div class="bookInfo">';
                         echo '<p class="bookTitle">'. $book[0] . "</p>";
                         echo '<p class="bookAuthor">'.$book[1].'</p>';
                         echo '</div>';
                         echo '</div>';
                         echo '</a>';
                      }
                      $first = false;
                  }
              }
              ?>
            </div>
          </div>

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

         <ul class="pagination justify-content-center mb-4">
            <li class="page-item">
              <a class="page-link" href="#">&larr; Back To Top</a>
            </li>
<!--
            <li class="page-item disabled">
              <a class="page-link" href="#">Newer &rarr;</a>
            </li>
-->
          </ul>


    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; LibrarEZ 2019</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
