<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindung zur Datenbank herstellen
include '../database/connection.php';

if (!isset($_SESSION['warenkorb'])) {
    $_SESSION['warenkorb'] = [];
}

// Funktion zum Hinzufügen eines Produkts zum Warenkorb
function addToCart($produktID)
{
    if (!isset($_SESSION['warenkorb'][$produktID])) {
        $_SESSION['warenkorb'][$produktID] = 0;
    }
    $_SESSION['warenkorb'][$produktID]++;
}

// Überprüfen, ob ein Produkt zum Warenkorb hinzugefügt werden soll
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    addToCart($_GET['id']);
    header("Location: index.php");
    exit();
}

// Anzahl der Artikel im Warenkorb zählen
function getCartCount()
{
    return array_sum($_SESSION['warenkorb']);
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
    <title>Home</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <a href='warenkorb.php'>Warenkorb anzeigen</a><br><br>
        <span id="cart-count" style="font-size: 1.5em; font-weight: bold;"><?php echo getCartCount(); ?></span>

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
                echo "<tr>
                        <td>{$row['ProduktID']}</td>
                        <td>{$row['Produktname']}</td>
                        <td>{$row['Beschreibung']}</td>
                        <td>{$row['Preis']} €</td>
                        <td>{$row['Energiewert']} kcal</td>
                        <td><img src='{$row['BildURL']}' alt='{$row['Produktname']}' width='100'></td>
                        <td><a href='index.php?action=add&id={$row['ProduktID']}'>In den Warenkorb</a></td>
                      </tr>";
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
