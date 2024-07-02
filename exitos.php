<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="https://cdn.pixabay.com/photo/2013/07/12/14/42/education-148605_1280.png"
        type="image/x-icon">
    <title>exitos</title>
</head>

<body>
    <div class="container-exitos">
        <p>Se subio correctamente!</p>
        <p>producto: <?= $_SESSION['prod'] ?></p>
        <a href="alta.php" class="btn">Volver</a>
    </div>
</body>

</html>