<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

    
    <title>Profile</title>
    <link rel = "stylesheet" href = "./assets/sty.css">

</head>

<body>

<?php

$initials="";

$words=explode(" ",$_SESSION["user_name"]);

foreach($words as $word){

$initials.=strtoupper($word[0]);

}

$initials=substr($initials,0,2);

?>

<div class="profile-card">

    <div class="profile-avatar">
        <?php
            $initials = "";
            foreach(explode(" ", $_SESSION["user_name"]) as $word){
                $initials .= strtoupper($word[0]);
            }
            echo substr($initials,0,2);
        ?>
    </div>

    <h1 class="profile-name">
        <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
    </h1>

    <p class="profile-subtitle">
        Welcome back, Explorer!
    </p>

    <div class="menu">

        <button
            type="button"
            class="posts"
            onclick="window.location.href='my_posts.php';">

            <span class="icon">My Posts</span>
            <span class="arrow">→</span>

        </button>

        <button
            type="button"
            class="reviews"
            onclick="window.location.href='my_reviews.php';">

            <span class="icon">My Reviews</span>
            <span class="arrow">→</span>

        </button>

        <button
            type="button"
            class="logout"
            onclick="window.location.href='logout.php';">

            <span class="icon">Logout</span>
            <span class="arrow">→</span>

        </button>

    </div>

    <button
        type="button"
        class="back"
        onclick="window.location.href='front.php';">

        ← Back

    </button>

</div>

</body>

</html>