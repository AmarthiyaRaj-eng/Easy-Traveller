<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET["id"] ?? null;

if (!$id || !is_numeric($id)) {
    die("Invalid destination ID");
}

$id = (int)$id;
?>

<!DOCTYPE html>
<html>
<head>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Roboto+Mono:wght@100..700&display=swap" rel="stylesheet">

<title>Add Review</title>

<link rel="stylesheet" href="./assets/script.css">

</head>

<body>

<div class="container">

    <form action="save_review.php" method="POST">

        <h1 class="ar-heading">Add Review</h1>

        <input type="hidden" name="destination_id" value="<?= htmlspecialchars($id) ?>">

        <textarea name="review" placeholder="Write your review..." required></textarea>

        <input type="number" name="rating" min="1" max="5" step="1" placeholder="Rate your experience" required>

        <button type="submit" class="save-btn">Submit Review</button>

        <button type="button" class="back-btn"
            onclick="window.location.href='destination.php?id=<?= htmlspecialchars($id) ?>'">
            Back
        </button>

    </form>

</div>

</body>
</html>