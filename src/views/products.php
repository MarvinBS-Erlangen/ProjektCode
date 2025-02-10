<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
include '../database/connection.php';

if (!isset($_SESSION['warenkorb'])) {
    $_SESSION['warenkorb'] = [];
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/products.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Produkte</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <h1 class="main-title">Produkte</h1>
        <div class="product-container">
            <?php
            $sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>
                            <div class='product-image'>
                                <img src='https://th.bing.com/th/id/OIP.gmNMTyBJy4LAshKKBsukZAHaFj?rs=1&pid=ImgDetMain' alt='{$row['Produktname']}'>
                            </div>
                            <div class='product-info'>
                                <div class='product-name'>{$row['Produktname']}</div>
                                <div class='product-price'>{$row['Preis']} €</div>
                                <button class='add-to-cart' data-produkt-id='{$row['ProduktID']}'><i class='fa-solid fa-cart-shopping cart-icon'></i>
                                </button>
                            </div>
                          </div>";
                }
            } else {
                echo "<p>Keine Produkte gefunden.</p>";
            }
            ?>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>
</body>

</html>
