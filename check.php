<?php
$conn = mysqli_connect("localhost", "root", "", "easy_traveller");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connected successfully";
?>