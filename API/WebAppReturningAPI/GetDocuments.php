<?php
    // $host        = "host = 127.0.0.1";
    // $port        = "port = 5432";
    // $dbname      = "dbname = digidocs-document";
    // $credentials = "user = root password=Root@123";

    $conn_string ="host=localhost port=5432 dbname=digidocs-document user=root password=Root@123";
    $bdd = pg_connect($conn_string);
 
    // $db = pg_connect( "$host $port $dbname $credentials"  );
    if(!$bdd) {
        echo "Error : Unable to open database\n";
    } else {
        echo "Opened database successfully\n";
    }
?>