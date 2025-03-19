<?php
// Datenbankverbindung herstellen
include '../database/connection.php';
// Session starten, wenn noch nicht gemacht
include '../comps/sessioncheck.php';
// Datenbank-Logik einbinden -- POST Requests an die Datenbank + Backend-Logik
include '../database/db_menus.php';
// Funktion zum Hinzufügen von Menüs in den Warenkorb
include '../comps/addMenueToCart.php';
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/menus.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="../handlers/menu-cart-icon-handler.js" defer></script>
    <script src="../handlers/menu-details-handler.js" defer></script> 
    <title>Menüs</title>
</head>

<body>
    <?php include './partials/header.php'; ?>
    <?php
    if (isset($_SESSION['success_message'])) {
        echo "<div class='success-banner'>" . $_SESSION['success_message'] . "</div>";
        unset($_SESSION['success_message']);
    }
    ?>

    <main class="main">
        <div class="menu-container">
            <?php
            $sql = "SELECT MenueID, Menuename, Beschreibung, DiscountPreis, NormalPreis, BildURL FROM menue";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='menu' data-id='{$row['MenueID']}'>
                            <div class='menu-image'>
                                <img src='{$row['BildURL']}' alt='{$row['Menuename']}'>
                            </div>
                            <div class='menu-info'>
                                <div class='menu-name'>{$row['Menuename']}</div>
                                <div class='menu-price'>{$row['DiscountPreis']} €</div>
                            </div>
                          </div>";
                }
            } else {
                echo "<p>Keine Menüs gefunden.</p>";
            }
            ?>
        </div>
    </main>

    <?php include './partials/footer.php'; ?>
</body>

</html>
<style>
/* Erfolgsmeldung-Banner */
.success-banner {
    width: 100%;
    background-color: #4CAF50; /* Grüner Hintergrund für Erfolg */
    color: white;
    text-align: center;
    padding: 5px;
    font-size: 16px;
    font-weight: bold;
    position: relative;
    margin-top: 0px;
    animation: fadeOut 3s forwards; /* Fade-out animation */
}

@keyframes fadeOut {
    0% {
        opacity: 1;
    }
    99% {
        opacity: 1;
    }
    100% {
        opacity: 0;
    }
}
</style>
