<?php
// Datenbankverbindung herstellen
include '../database/connection.php';
// Start der Session
include '../comps/sessioncheck.php';
// Funktion zum Abrufen von Menüdetails
include '../database/db_menus.php';

// Prüfen, ob die Menü-ID über die URL übergeben wurde
if (isset($_GET['id'])) {
    $menueID = $_GET['id'];
    $sql = "SELECT * FROM menue WHERE MenueID = $menueID";
    $result = $conn->query($sql);
    $menu = $result->fetch_assoc();
} else {
    die("Menü nicht gefunden.");
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/menu_details.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Menü Details</title>
</head>

<body>
    <?php include './partials/header.php'; ?>

    <main class="main">
        <div class="container">
            <!-- Bild -->
            <div class="menu-image-container">
                <img src="<?php echo $menu['BildURL']; ?>" alt="<?php echo $menu['Menuename']; ?>">
            </div>

            <!-- Menüdetails -->
            <div class="menu-details">
                <h1 class="menu-title"><?php echo $menu['Menuename']; ?></h1>
                <div class="pricing">
                    <span class="new-price"><?php echo $menu['DiscountPreis']; ?> €</span>
                    <span class="old-price"><?php echo $menu['NormalPreis']; ?> €</span>
                </div>

                <p class="description">
                    <?php echo $menu['Beschreibung']; ?>
                </p>

                <p class="energy-info"><strong><?php echo $menu['Energiewert']; ?> kcal</strong></p>

                <a href="menus.php?action=add&id=<?php echo $menu['MenueID']; ?>" class="cart-icon">
                    <i class="fa-solid fa-cart-shopping"></i> In den Warenkorb
                </a>
            </div>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>
</body>

</html>
