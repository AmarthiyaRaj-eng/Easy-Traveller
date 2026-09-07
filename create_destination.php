<?php
session_start();
include "config/db.php";

if (!isset($_SESSION['user_id'])) {
    die("Login required");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $weather = mysqli_real_escape_string($conn, $_POST['weather']);

    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO destinations
            (name, state, description, weather, created_by)
            VALUES
            ('$name', '$state', '$description', '$weather', '$user_id')";

    if (mysqli_query($conn, $sql)) {
        header("Location: front.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Destination</title>
    <link rel="stylesheet" href="./assets/css.css">
</head>

<body>

<form method="POST">

    <h2>Add New Destination</h2>

    <input
        type="text"
        name="name"
        placeholder="Place Name"
        required
    >

    <input
        type="text"
        name="state"
        placeholder="State"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
        rows="5"
        required
    ></textarea>

    <input
        type="text"
        name="weather"
        placeholder="Weather"
    >

    <button type="submit">
        Post Destination
    </button>
    
    <button type="submit" onclick="window.location.href='front.php'">
        Back to menu
    </button>
    
</form>

</body>
</html>