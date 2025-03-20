<?php
// Datenbankverbindung herstellen
include '../database/connection.php';
// Start der Session
include '../comps/sessioncheck.php';

// Produkt-ID aus der URL holen
$productID = isset($_GET['id']) ? $_GET['id'] : null;

if ($productID) {
    // Abrufen der Produktdetails aus der Datenbank
    $sql = "SELECT ProduktID, Produktname, Beschreibung, Preis, Energiewert, BildURL FROM produkt WHERE ProduktID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<p>Produkt nicht gefunden.</p>";
        exit;
    }

    // Zutaten für das Produkt abrufen
    $sql_ingredients = "SELECT z.Zutatenname
                        FROM produkt_zutat pz
                        JOIN zutat z ON pz.ZutatID = z.ZutatID
                        WHERE pz.ProduktID = ?";
    $stmt = $conn->prepare($sql_ingredients);
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result_ingredients = $stmt->get_result();
    $zutaten = [];
    while ($row = $result_ingredients->fetch_assoc()) {
        $zutaten[] = $row['Zutatenname'];
    }
} else {
    echo "<p>Keine Produkt-ID angegeben.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">

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
    <title>Produktdetails</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="container">
            <!-- Bild -->
            <div class="image-container">
                <img src="<?php echo $product['BildURL']; ?>" alt="<?php echo $product['Produktname']; ?>" onerror="this.src='https://cdn3.iconfinder.com/data/icons/it-and-ui-mixed-filled-outlines/48/default_image-1024.png';">
            </div>

            <!-- Produktdetails -->
            <div class="product-details">
                <h1 class="product-title"><?php echo $product['Produktname']; ?></h1>
                <div class="pricing">
                    <span class="new-price"><?php echo number_format($product['Preis'], 2); ?> €</span>
                </div>

                <p class="energy-info"><strong><?php echo $product['Energiewert']; ?> kcal</strong></p>

                <p class="description">
                    <?php echo $product['Beschreibung']; ?>
                </p>

                <p class="included-ingredients">
                    <strong>In diesem Produkt enthaltene Zutaten:</strong>
                <ul class="included-ingredients-list">
                    <?php foreach ($zutaten as $zutat) {
                        echo "<li>$zutat</li>";
                    } ?>
                </ul>
                </p>
            </div>
            <a href="products.php?action=add&id=<?php echo $product['ProduktID']; ?>" class="cart-icon">
                <i class="fa-solid fa-cart-shopping product-cart-icon"></i>
            </a>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>
</body>

</html>