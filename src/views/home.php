<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">

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
    <script src="../handlers/home-image-blendin.js" defer></script>
    <title>Home</title>
</head>

<body id="main">
    <?php include './partials/header.php'; ?>

    <div id="img-div">
        <img id="image" src="https://plasticcontainercity.com/media/magefan_blog/fruit-_-veg.jpg" alt="veggies">

        <p><strong>Welcome to MacApple – where healthy meets fast, fresh, and affordable!</strong></p>
        <p>Dear customer,</p>

        <p>life is busy. We get it. Between work, family, and everything else in between, the last thing you want to do is spend hours in the kitchen. But guess what? You don’t have to sacrifice health for convenience. At MacApple, we believe in making nutritious, mouthwatering meals that fit seamlessly into your fast-paced lifestyle.</p>

        <p>Our food is made with only the finest, freshest ingredients – no preservatives, no shortcuts, just wholesome goodness. From vibrant salads to satisfying wraps and bowls, every dish is designed to fuel your body and leave you feeling energized and refreshed.</p>

        <p>Don’t let time or convenience stand in the way of eating healthy. Whether you’re rushing between meetings or just looking for a simple, delicious meal, we’ve got you covered. Enjoy real food at a real price – because you deserve to feel your best, even on your busiest days.</p>

        <p>Ready to make a change? Let us take care of <a id="products-link" href="./products.php" target="_blank">your healthy cravings</a>, fast!</em></p>

        <p> Yours, </p>
        <p> MacApple Team </p>


        <?php include './partials/footer.php'; ?>




</body>

</html>
