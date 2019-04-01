<?php
   $host = "host = librarezdb.cbarom9u2wq0.us-east-2.rds.amazonaws.com";
   $port = "port = 5432";
   $dbname = "dbname = LibrarEZDB";
   $credentials = "user= librarEZAdmin password=adminpass";
    
    $db = pg_connect("$host $port $dbname $credentials" );
    if(!db){
        echo "Error: unable to open database\n";
    }
    else{
        echo "Connection successful\n";
    }
?>