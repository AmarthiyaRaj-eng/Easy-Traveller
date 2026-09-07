<?php
session_start();
include "config/db.php";

$id = $_GET["id"] ?? null;

if ($id === null || !is_numeric($id)) {
    die("Invalid destination ID");
}

$id = (int)$id;

$stmt = mysqli_prepare($conn, "
    SELECT d.*, u.fullname
    FROM destinations d
    LEFT JOIN users u ON d.created_by = u.id
    WHERE d.id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Destination not found");
}

$destination = mysqli_fetch_assoc($result);

$reviewStmt = mysqli_prepare($conn, "
    SELECT
        r.review,
        r.rating,
        u.id AS user_id,
        u.fullname
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.destination_id = ?
    ORDER BY r.id DESC
");

mysqli_stmt_bind_param($reviewStmt, "i", $id);
mysqli_stmt_execute($reviewStmt);
$reviewsResult = mysqli_stmt_get_result($reviewStmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($destination["name"]) ?></title>
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body>

<div class="container">

    <h1><?= htmlspecialchars($destination["name"]) ?></h1>

    <h2 class="r-heading">Reviews</h2>

    <?php if (mysqli_num_rows($reviewsResult) > 0): ?>

        <?php while ($review = mysqli_fetch_assoc($reviewsResult)): ?>

            <div class="review-card">

                <a href="user_posts.php?id=<?php echo $review["user_id"]; ?>">
                    <?php echo htmlspecialchars($review["fullname"]); ?>
                </a>

                <p><?= htmlspecialchars($review["review"]) ?></p>

                <p class="r-rating">
                    ⭐ <?= htmlspecialchars($review["rating"]) ?>/5
                </p>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <p class="r1">No reviews yet.</p>

    <?php endif; ?>

    <br>

    <div class="btn-container">
        <a class="review-btn" href="add_review.php?id=<?= $id ?>">
            Add Review
        </a>
    
        <button onclick="window.location.href='front.php'" class="home-btn">
            Back to Menu
        </button>
    </div>


</div>

</body>
</html>