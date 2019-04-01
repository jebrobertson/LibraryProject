<?php

//Include config file
require_once 'libconfig.php';


//Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";


//Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
/*
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username";
    }
    else{
        $username = trim($_POST["username"]);
    }
    
    //check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Please enter your password.';
    }
    else{
        $password = trim($_POST['password']);
    }
*/
    //validate credentials
    if(empty($username_err) && empty($password_err)){
        //try to prevent SQL-Injection
        $query = 'SELECT * FROM login WHERE username=$1 AND password=$2';
        $result = pg_query_params($db, $query, array($_POST["username"], $_POST["password"]));
        
        if(pg_num_rows($result) < 1){
            echo nl2br("Username or Password does not exist.\n Please Try Again.\n Page will refresh in 5\n");
            header('Refresh: 5; URL=http://ec2-3-94-120-99.compute-1.amazonaws.com');
        }
        else if(pg_num_rows($result) == 1){
            //save username to session
            session_start();
            $_SESSION['username'] = $username;
            header("location: index.html");
        }
    }


  //close connection
    pg_close($dbconn);

}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LibrarEZ Login</title>
    </head>
    <body>
        <h2>LibrarEZ Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
                <span><?php echo $username_err; ?></span>
            </div>
            
            <div class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password">
                <span><?php echo $password_err; ?></span>
            </div>
            
            <div>
                <input type="submit" value="Login">
            </div>
        </form>
    </body>
</html>