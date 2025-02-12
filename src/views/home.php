<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/home.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>MacApple - Welcome</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="welcome-container">
            <h1 class="fade-in">WELCOME TO MACAPPLE</h1>
            <h2 class="fade-in delay">Hungry? Have a craving? Or just want a treat?</h2>
            <p class="fade-in delay">Now only one click away!</p>
            <a href="./menus.php" class="btn">Explore Menu</a>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>

</html>
