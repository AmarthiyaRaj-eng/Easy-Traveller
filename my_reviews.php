<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$stmt = mysqli_prepare($conn, "
    SELECT r.review,
           r.rating,
           r.destination_id,
           d.name AS destination_name
    FROM reviews r
    JOIN destinations d
        ON r.destination_id = d.id
    WHERE r.user_id = ?
    ORDER BY r.id DESC
");

mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Reviews</title>

<link rel="stylesheet" href="./assets/style.css">
<link rel="stylesheet" href="./assets/sheet.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Alien+Block&family=Archivo+Black&display=swap" rel="stylesheet">

</head>

<body>

<div class="container">

    <h1>My Reviews</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>

        <?php while ($review = mysqli_fetch_assoc($result)): ?>

            <div class="review-card">

                <h3>
                    <?php echo htmlspecialchars($review["destination_name"]); ?>
                </h3>

                <p>
                    <?php echo nl2br(htmlspecialchars($review["review"])); ?>
                </p>

                <p class="r-rating">
                    ⭐ <?php echo htmlspecialchars($review["rating"]); ?>/5
                </p>

                <div class="btn-container">

                    <button
                        class="review-btn"
                        onclick="window.location.href='destination.php?id=<?php echo $review['destination_id']; ?>'">

                        View Destination

                    </button>

                </div>

            </div>

            <br>

        <?php endwhile; ?>

    <?php else: ?>

        <p class="r1">
            You haven't reviewed any destinations yet.
        </p>

    <?php endif; ?>

    <br>

    <div class="btn-container">

        <button
            onclick="window.location.href='profile.php'"
            class="home-btn">

            Back to Profile

        </button>

    </div>

</div>

</body>
</html>