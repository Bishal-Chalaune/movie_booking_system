<?php 

    $host = "localhost";
    $dbuser = "root";
    $dbpwd = "";
    $dbname = "movie_system";

    $conn = new mysqli($host, $dbuser, $dbpwd, $dbname);
    if(!$conn) {
        die("Database connection failed!");
    }

?>