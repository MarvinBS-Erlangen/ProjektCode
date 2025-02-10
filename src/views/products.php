<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
include '../database/connection.php';

if (!isset($_SESSION['warenkorb_Produkt'])) {
    $_SESSION['warenkorb_Produkt'] = [];
}

// Funktion zum Hinzufügen eines Produkts zum Warenkorb
function addToCart($produktID)
{
    if (!isset($_SESSION['warenkorb_Produkt'][$produktID])) {
        $_SESSION['warenkorb_Produkt'][$produktID] = 0;
    }
    $_SESSION['warenkorb_Produkt'][$produktID]++;
}

// Überprüfen, ob ein Produkt zum Warenkorb hinzugefügt werden soll
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    addToCart($_GET['id']);
    header("Location: products.php");
    exit();
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
        <a href='warenkorb.php'>Warenkorb anzeigen</a><br><br>
        <span id="cart-count" style="font-size: 1.5em; font-weight: bold;"><?php echo getCartCount(); ?></span>

        <div class="product-container">
            <?php
            $sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>
                            <div class='product-image'>
                                <img src='{$row['BildURL']}' alt='{$row['Produktname']}'>
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
