<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$destination_id = $_POST["destination_id"] ?? null;
$review = trim($_POST["review"] ?? "");
$rating = $_POST["rating"] ?? null;

if (!$destination_id || !is_numeric($destination_id)) {
    die("Destination not found");
}

if (empty($review) || !$rating) {
    die("All fields are required");
}

$destination_id = (int)$destination_id;
$rating = (int)$rating;

$check = $conn->prepare("SELECT id FROM destinations WHERE id = ?");
$check->bind_param("i", $destination_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    die("Destination not found");
}

$stmt = $conn->prepare("
    INSERT INTO reviews (destination_id, user_id, review, rating)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("iisi", $destination_id, $user_id, $review, $rating);

if ($stmt->execute()) {
    header("Location: destination.php?id=" . $destination_id);
    exit();
} else {
    die("Error saving review");
}
?>