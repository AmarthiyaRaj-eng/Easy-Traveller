<?php
session_start();

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}
?>

<h1>Admin Panel</h1>

<p>Welcome Admin: <?php echo $_SESSION["user_name"]; ?></p>

<a href="logout.php">Logout</a>