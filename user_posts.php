<?php
session_start();
include "./config/db.php";

if (!isset($_GET['id'])) {
    die("Invalid User.");
}

$user_id = (int)$_GET['id'];

$user_stmt = mysqli_prepare($conn, "
    SELECT
        users.fullname,
        COUNT(destinations.id) AS total_posts
    FROM users
    LEFT JOIN destinations
        ON users.id = destinations.created_by
    WHERE users.id = ?
    GROUP BY users.id
");

mysqli_stmt_bind_param($user_stmt, "i", $user_id);
mysqli_stmt_execute($user_stmt);
$user_result = mysqli_stmt_get_result($user_stmt);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    die("User not found.");
}

$stmt = mysqli_prepare($conn, "
    SELECT
        id,
        name,
        state,
        description,
        weather
    FROM destinations
    WHERE created_by = ?
    ORDER BY id DESC
");

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Posts</title>
    <link rel="stylesheet" href="./assets/stylee.css">
</head>

<body>

<div class="top-bar">
    <a href="front.php" class="back-btn">← Back</a>
</div>

<div class="profile-header">
    <h1><?php echo htmlspecialchars($user['fullname']); ?></h1>
    <h3>Total Posts: <?php echo $user['total_posts']; ?></h3>
</div>

<?php
if (mysqli_num_rows($result) == 0) {

    echo "<p class='no-posts'>No posts here.</p>";

} else {

    while ($row = mysqli_fetch_assoc($result)) {

        echo "<div class='user-posts'>";

        echo "<h1>" . htmlspecialchars($row['name']) . "</h1>";

        echo "<p><strong>State:</strong> "
            . htmlspecialchars($row['state']) . "</p>";

        echo "<p><strong>Description:</strong><br>"
            . nl2br(htmlspecialchars($row['description'])) . "</p>";

        echo "<p><strong>Weather:</strong> "
            . htmlspecialchars($row['weather']) . "</p>";

        echo "</div>";
    }
}
?>

</body>
</html>