<?php
session_start();
include "config/db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] != "admin") {
    header("Location: index.php");
    exit();
}

$sql = "
    SELECT users.id,
           users.fullname,
           users.email,
           users.created_at,
           users.role,
           users.password,
           COUNT(destinations.id) AS total_posts
    FROM users
    LEFT JOIN destinations
        ON users.id = destinations.created_by
    GROUP BY users.id
    ORDER BY users.id DESC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="./assets/script.css">
</head>

<body>

<div class="container">

    <div class="top-buttons">

        <a href="front.php" class="home-button">
            <button type="button">Back</button>
        </a>

        <button type="button" onclick="toggleUsers()" class="show-users">
            Show Users
        </button>

    </div>

    <h1 class="no-heading">Admin Panel</h1>

    <div class="destination-grid" id="usersBox" style="display:none;">

        <?php if (mysqli_num_rows($result) > 0) { ?>

        <div class="user-table">

            <table class="user-table">

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Posts</th>
                    <th>Created At</th>
                    <th>Role</th>
                </tr>

                <?php while ($user = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?= $user['id'] ?></td>

                    <td>
                        <a href="user_posts.php?id=<?= $user['id'] ?>">
                            <?= htmlspecialchars($user['fullname']) ?>
                        </a>
                    </td>

                    <td><?= htmlspecialchars($user['email']) ?></td>

                    <td><?= $user['total_posts'] ?></td>

                    <td><?= $user['created_at'] ?></td>

                    <td><?= htmlspecialchars($user['role']) ?></td>

                </tr>

                <?php } ?>

            </table>

        </div>

        <?php } else { ?>

            <div class="no-user">
                <h2>No users found.</h2>
            </div>

        <?php } ?>

    </div>

</div>

<script>
function toggleUsers() {

    const box = document.getElementById("usersBox");

    if (box.style.display === "none" || box.style.display === "") {
        box.style.display = "grid";
    } else {
        box.style.display = "none";
    }

}
</script>

</body>
</html>