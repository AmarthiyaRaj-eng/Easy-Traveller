<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "easy_traveller";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

?>
