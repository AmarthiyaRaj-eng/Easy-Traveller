<?php
session_start();
include "config/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode([
        "success" => false,
        "message" => "Please login first."
    ]);
    exit();
}

$user_id = $_SESSION["user_id"];
$destination_id = intval($_POST["destination_id"]);

$stmt = $conn->prepare("
SELECT id
FROM likes
WHERE user_id = ?
AND destination_id = ?
");

$stmt->bind_param("ii", $user_id, $destination_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $stmt = $conn->prepare("
    DELETE FROM likes
    WHERE user_id = ?
    AND destination_id = ?
    ");

    $stmt->bind_param("ii", $user_id, $destination_id);
    $stmt->execute();

    $liked = false;

} else {

    $stmt = $conn->prepare("
    INSERT INTO likes(user_id, destination_id)
    VALUES(?, ?)
    ");

    $stmt->bind_param("ii", $user_id, $destination_id);
    $stmt->execute();

    $liked = true;
}

$stmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM likes
WHERE destination_id = ?
");

$stmt->bind_param("i", $destination_id);
$stmt->execute();

$count = $stmt->get_result()->fetch_assoc();

echo json_encode([
    "success" => true,
    "liked" => $liked,
    "likes" => $count["total"]
]);