<?php
session_start();
include "config/db.php";
?>

<!DOCTYPE html>
<html>
<head>

<link rel='stylesheet' href='./assets/styles.css'>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Alien+Block&family=BBH+Hegarty&family=Bitcount+Grid+Double:wght@100..900&family=Bitcount+Prop+Single:wght@100..900&family=Inconsolata:wght@200..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Science+Gothic:wght@100..900&family=Stack+Sans+Notch:wght@200..700&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Alien+Block&family=Archivo+Black&family=BBH+Hegarty&family=BioRhyme+Expanded:wght@200;300;400;700;800&family=Bitcount+Grid+Double:wght@100..900&family=Bitcount+Prop+Single:wght@100..900&family=Changa+One:ital@0;1&family=Inconsolata:wght@200..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Science+Gothic:wght@100..900&family=Stack+Sans+Notch:wght@200..700&display=swap" rel="stylesheet">

<script>

function flyToPage(page){

    document.getElementById("plane").classList.add("fly");

    document.querySelectorAll(".smoke").forEach(smoke=>{
        smoke.classList.add("smokeFly");
    });

    setTimeout(()=>{

        window.location.href=page;

    },1200);

}
</script>

</head>

<body>

<div class='header'>
    <div class='navbar'>

        <?php if (!isset($_SESSION['user_id'])) { ?>

            <button type='button' onclick="window.location.href='login.php'">
                Sign In
            </button>

        <?php } else { ?>

            <span style="color:#1f1f1f; margin-right:15px;">
                Welcome, <?php echo $_SESSION['user_name']; ?>
            </span>

            <button type='button' onclick="window.location.href='logout.php'">
                Logout
            </button>

        <?php } ?>

    </div>
</div>

<div class='front'>
    <div class='heading'>
        <p class='front-heading'>Easy Traveller</p>

        <div class='front-description'>
            <p>
                Discover the world like never before with Easy Traveller,
                your all-in-one travel companion. Whether you’re exploring hidden gems
                or planning an international adventure, Easy Traveller makes every journey effortless and exciting.
            </p>
        </div>
    </div>
</div>

<div class='description'>

    <p class='d-heading'>How to use</p>

    <div class='d-details'>
        <div class='d1'>
            Discover famous tourist attractions with detailed information, weather updates, travel tips and more.
        </div>

        <div class='d2'>
            Read reviews from other travellers and share your own experiences to help others plan their trips.
        </div>

        <div class='d3'>
            Find destination details, nearby attractions and useful travel information in one place.
        </div>
    </div>

</div>

<div class='middle'>
    <div class='m-content'>
        <p class='c-heading'>Hear out Honest Reviews from visitors.</p>
        <p class='c1'>Share opinions and new spots to others</p>

        <button type='button' onclick="window.location.href='front.php'" class='travel-btn'>
            Explore Places →
        </button>
    </div>
</div>


</body>
</html>