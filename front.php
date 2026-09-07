<?php
session_start();
include "config/db.php";

$search = "";
$user_id = $_SESSION["user_id"] ?? 0;

if (isset($_GET["search"]) && trim($_GET["search"]) != "") {

    $search = trim($_GET["search"]);
    $like = "%" . $search . "%";

    $stmt = $conn->prepare("
        SELECT
            d.*,
            u.fullname,
            u.id AS user_id,
            COUNT(l.id) AS total_likes,
            MAX(CASE WHEN l.user_id = ? THEN 1 ELSE 0 END) AS liked
        FROM destinations d
        LEFT JOIN users u
            ON d.created_by = u.id
        LEFT JOIN likes l
            ON d.id = l.destination_id
        WHERE d.name LIKE ?
        GROUP BY
            d.id,
            d.name,
            d.state,
            d.description,
            d.weather,
            d.image,
            d.created_by,
            d.created_at,
            u.fullname,
            u.id
        ORDER BY RAND()
    ");

    $stmt->bind_param("is", $user_id, $like);
    $stmt->execute();
    $result = $stmt->get_result();

} else {

    $stmt = $conn->prepare("
        SELECT
            d.*,
            u.fullname,
            u.id AS user_id,
            COUNT(l.id) AS total_likes,
            MAX(CASE WHEN l.user_id = ? THEN 1 ELSE 0 END) AS liked
        FROM destinations d
        LEFT JOIN users u
            ON d.created_by = u.id
        LEFT JOIN likes l
            ON d.id = l.destination_id
        GROUP BY
            d.id,
            d.name,
            d.state,
            d.description,
            d.weather,
            d.image,
            d.created_by,
            d.created_at,
            u.fullname,
            u.id
        ORDER BY RAND()
    ");

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

$initials = "";

if (isset($_SESSION["user_name"])) {

    $words = explode(" ", trim($_SESSION["user_name"]));

    foreach ($words as $word) {
        if (!empty($word)) {
            $initials .= strtoupper($word[0]);
        }
    }

    $initials = substr($initials, 0, 2);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tourist Guide App</title>

<link rel="stylesheet" href="./assets/style.css">
<link rel="stylesheet" href="./assets/sheet.css">

<link href="https://fonts.googleapis.com/css2?family=Alien+Block&family=Archivo+Black&display=swap" rel="stylesheet">

</head>


<body>

<div class="container">

<div class="top-buttons">

<a href="index.php" class="home-button">
<button type="button">Back To Home</button>
</a>

<?php if(isset($_SESSION["user_id"])) { ?>

    <?php if($_SESSION["role"]=="admin") { ?>

        <button
        type="button"
        class="my-posts"
        onclick="window.location.href='admin_details.php'">
        User Details
        </button>

    <?php } else { ?>

        <button
        type="button"
        class="add-destination"
        onclick="window.location.href='create_destination.php'">
        +
        </button>

        <button
        type="button"
        class="profile-btn"
        onclick="window.location.href='profile.php'">
        <?php echo $initials; ?>
        </button>

    <?php } ?>

<?php } ?>

</div>

<form method="GET">

<input
type="text"
name="search"
class="add-bar"
placeholder="Search destination..."
value="<?php echo htmlspecialchars($search); ?>">

</form>

<br>

<div class="destination-grid">

<?php if(mysqli_num_rows($result)>0){ ?>

<?php while($place=mysqli_fetch_assoc($result)){ ?>

<div class="card">

<div class="posted-by">

<a href="user_posts.php?id=<?php echo $place["user_id"]; ?>">
<?php echo htmlspecialchars($place["fullname"] ?? "Unknown User"); ?>
</a>

</div>

<h1><?php echo htmlspecialchars($place["name"]); ?></h1>

<h4><?php echo htmlspecialchars($place["state"]); ?></h4>

<p class="description">
<?php echo nl2br(htmlspecialchars($place["description"])); ?>
</p>

<p>

<strong>Weather:</strong>

<?php echo htmlspecialchars($place["weather"]); ?>

</p>

<div class="card-actions">

<button
type="button"
class="like-btn"
data-id="<?php echo $place["id"]; ?>">

<span class="heart">
<?php echo $place["liked"] ? "❤️" : "🤍"; ?>
</span>

<span class="like-count">
<?php echo $place["total_likes"]; ?>
</span>

</button>

<a href="destination.php?id=<?php echo $place["id"]; ?>">

<button
type="button"
class="view-review">
💬
</button>

</a>

</div>

</div>

<?php } ?>

<?php } else { ?>

<h2>No destinations found.</h2>

<?php } ?>

</div>

</div>

<script>

document.querySelectorAll(".like-btn").forEach(button => {

    button.addEventListener("click", function () {

        let btn = this;

        fetch("toggle_like.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: "destination_id=" + btn.dataset.id

        })

        .then(response => response.json())

        .then(data => {

            if(data.success){

                btn.querySelector(".like-count").textContent = data.likes;

                btn.querySelector(".heart").textContent =
                    data.liked ? "❤️" : "🤍";

            }

        })

        .catch(error => console.log(error));

    });

});

</script>

</body>
</html>