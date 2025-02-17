<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_register.php';
//Funktion zum hinzufuegen von Produkten in den Warenkorb
include '../comps/addProductToCart.php';
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
    <script src="../handlers/product-cart-icon-handler.js" defer></script>
    <title>Produkte</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
  

        <div class="product-container">
            <?php
            $sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>
                            <div class='product-image'>
                                <img src='../public/assets/test1.png' alt='{$row['Produktname']}'>
                            </div>
                            <div class='product-info'>
                                <div class='product-name'>{$row['Produktname']}</div>
                                <div class='product-price'>{$row['Preis']} €</div>
                                <a href='products.php?action=add&id={$row['ProduktID']}' class='cart-icon'>
                                    <i class='fa-solid fa-cart-shopping'></i>
                                </a>
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
