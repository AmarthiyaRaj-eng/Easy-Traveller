<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT *
    FROM destinations
    WHERE created_by = ?
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>My Posts</title>

<link rel="stylesheet" href="./assets/style.css">
<link rel="stylesheet" href="./assets/script.css" 

</head>

<body>

<div class="container">

<div class="top-buttons">

    <a href="front.php" class="home-button">
        <button type="button">
            ← Back
        </button>
    </a>

</div>

<h1>My Destinations</h1>

<div class="destination-grid">

<?php

if ($result->num_rows > 0) {

    while ($place = $result->fetch_assoc()) {

?>

<div class="card">

    <h2><?php echo htmlspecialchars($place["name"]); ?></h2>

    <h4><?php echo htmlspecialchars($place["state"]); ?></h4>

    <p><?php echo htmlspecialchars($place["description"]); ?></p>

    <p>
        <strong>Weather:</strong>
        <?php echo htmlspecialchars($place["weather"]); ?>
    </p>
</div>

<?php

    }

} else {

    echo "<h2>You haven't posted any destinations yet.</h2>";

}

?>

</div>

</div>

</body>
</html>