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
    <link rel="stylesheet" href="../public/styles/index-products.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Einbinden von Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="../handlers/cart-icon-handler.js" defer></script>
    <title>Home</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <?php
        $sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='product-grid'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>
                    <img src='{$row['BildURL']}' alt='{$row['Produktname']}' class='product-image'>
                    <h2 class='product-name'>{$row['Produktname']}</h2>
                    <p class='product-description'>{$row['Beschreibung']}</p>
                    <p class='product-price'>{$row['Preis']} €</p>
                    <p class='product-energy'>{$row['Energiewert']} kcal</p>
                    <button class='add-to-cart' data-produkt-id='{$row['ProduktID']}'>In den Warenkorb</button>
                  </div>";
            }
            echo "</div>";
        } else {
            echo "<p>Keine Produkte gefunden.</p>";
        }
        ?>
    </main>


    <?php include './partials/footer.php'; ?>

</body>

</html>
