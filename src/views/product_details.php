<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/product_details.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/product-details-cart-handler.js" defer></script>
    <title>Product Details</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="container">
            <!-- Image -->
            <div class="image-container">
                <img src="https://assets-au-01.kc-usercontent.com/ab37095e-a9cb-025f-8a0d-c6d89400e446/17d49270-1b2a-4511-80a8-1c5dbd41e8c8/article-cat-vet-visit-guide.jpg"
                    alt="Nachos Snackers">
            </div>

            <!-- Product Details -->
            <div class="product-details">
                <h1 class="product-title">NACHOS SNACKERS</h1>
                <div class="pricing">
                    <span class="new-price">12.99 €</span>
                </div>

                <p class="energy-info"><strong>1026 kJ | 246 kcal</strong></p>

                <p class="description">
                    Viva los Snackers: Was ist <span class="bold">knackig</span>, <span class="bold">cremig</span> und würzig gleichzeitig?
                    <span class="bold">Correcto</span>, unsere verführerischen Nacho Cheese Snackers.
                    Mit ihrer einmalig knusprigen Panade mit Tortilla Chips aus purem Maismehl und einem herzhaften,
                    zartschmelzenden Kern – da muss man einfach zugreifen. Dazu gibt’s mittlere Pommes und 0,4l Softdrink.
                </p>
            </div>
            <i class="fa-solid fa-cart-shopping product-cart-icon"></i>
        </div>

    </main>

    <?php include './partials/footer.php'; ?>


</body>

</html>
