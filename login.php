<?php
session_start();
include "config/db.php";

$form = $_GET['form'] ?? 'signin';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {

    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>alert('Email already exists');</script>";

    } else {

        $sql = "INSERT INTO users(fullname,email,password,role)
                VALUES('$name','$email','$password','user')";

        if (mysqli_query($conn, $sql)) {

            echo "<script>alert('Account created successfully');</script>";
            $form = "signin";
        } else if(isset($users["fullname"])) {
            echo "<script>alert('User already exists. Please use another username');</script>";
        } else if(isset($users["email"])) {
            echo "<script>alert('Email already exists. PLease use another email adress');</script>";    
        }else if(isset($users["password"])){
            echo "<script>alert('Password already exist. PLease use another password');</script>";
        } else {
            echo "<script>alert('Registration failed');</script>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["fullname"];
            $_SESSION["role"] = $user["role"];

            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
            
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Easy Traveller</title>

    <link rel="stylesheet" href="./assets/index.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Alien+Block&family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Alien+Block&family=Archivo+Black&family=BBH+Hegarty&family=BioRhyme+Expanded:wght@200;300;400;700;800&family=Bitcount+Grid+Double:wght@100..900&family=Bitcount+Prop+Single:wght@100..900&family=Changa+One:ital@0;1&family=Inconsolata:wght@200..900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Science+Gothic:wght@100..900&family=Stack+Sans+Notch:wght@200..700&display=swap" rel="stylesheet">


</head>

<body>

<div class="front">
    <p class="front-heading">Easy Traveller</p>
</div>

<div class="sin-sout">

    <button
        class="sign-in <?php echo ($form=="signin") ? "active" : ""; ?>"
        onclick="window.location='?form=signin'">
        Sign In
    </button>

    <button
        class="sign-out <?php echo ($form=="signup") ? "active" : ""; ?>"
        onclick="window.location='?form=signup'">
        Sign Up
    </button>

</div>

<?php if($form=="signin"){ ?>

<div class="form-in">

    <p>Welcome Back</p>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
        >
        <br><br>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required>

        <br><br>

        <button
            class="login"
            name="login"
            type="submit">
            Sign In
        </button>

    </form>

</div>

<?php } else { ?>

<div class="form-out">

    <p>Create Your Account</p>

    <form method="POST">

        <input
            type="text"
            name="fullname"
            placeholder="Full Name"
            required>

        <br><br>

        <input
            type="email"
            name="email"
            placeholder="Email"
            required>

        <br><br>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required>

        <br><br>

        <input
            type="password"
            name="cpassword"
            placeholder="Confirm Password"
            required>

        <br><br>

        <button
            class="create"
            name="signup"
            type="submit">
            Create Account
        </button>

    </form>

</div>

<?php } ?>

</body>
</html>