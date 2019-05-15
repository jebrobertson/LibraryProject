
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
              session_start();
              if($_SESSION['rank'] == 'Admin' || $_SESSION['rank'] == 'Librarian'){
              ?>
              <li class="nav-item">
              <a class="nav-link" href="viewQueue.php">View Queue</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="addBook.php">Add Book</a>
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
