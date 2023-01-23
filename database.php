<?php

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "mnnit";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if(!$conn){
    die('Connection failed');
}

?>