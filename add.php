<!DOCTYPE html>

<html>

<head>

<title>Add Destination</title>

<link rel="stylesheet" href="./assets/style.css">

</head>

<body>
    
<div class="container">
    <h1>Add New Destination</h1>
    <form action="save.php" method="POST">
        <input
        type="text"
        name="name"
        placeholder="Destination Name"
        required>

        <input
        type="text"
        name="state"
        placeholder="State"
        required>

        <textarea
        name="description"
        placeholder="Description"
        required>

        </textarea>

        <input
        type="text"
        name="weather"
        placeholder="Weather"
        required>

        <input
        type="number"
        step="0.1"
        name="rating"
        placeholder="Rating"
        required>

    <div class='destn-btn'>
        <button class='save-destn'>
        Save Destination
        </button>
        
        <button
        onclick="window.location.href='front.php?id=<?= $id ?>'"
        class='home-btn'>
        Back to Menu 
        </button>
    </div>
    </form>

</div>
</body>
</html>