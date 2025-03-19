<?php
//Datenbank verbindung herstellen
include '../database/connection.php';
//Start der Session
//Sessions initialisieren wenn noch nicht gemacht
include '../comps/sessioncheck.php';
//Schaue ob der Benuzter eingelogt ist
include '../comps/usercheck.php';
//Datenbank Logik einbinden -- POST Requests an die Datenbank + Backend Logik
include '../database/db_warenkorb.php';
?>

<!-- Frontend & Database Display -->
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/reset.css">
    <link rel="stylesheet" href="../public/styles/index.css">
    <link rel="stylesheet" href="../public/styles/warenkorb.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/header.css">
    <link rel="stylesheet" href="../public/styles/partialStyles/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Warenkorb</title>
</head>

<body>
    <?php include './partials/header.php'; ?>
    <?php
    // Überprüfen, ob eine Fehlermeldung in der Session vorhanden ist
    if (isset($_SESSION['error_message_cart'])) {
        // Fehlermeldung anzeigen
        echo "<div class='error-banner'>" . $_SESSION['error_message_cart'] . "</div>";
        
        // Fehlermeldung nach der Anzeige aus der Session löschen
        unset($_SESSION['error_message_cart']);
    }
    ?>
    <main class="main">
        <div class="container">
            <div class="section">
                <h2>Bestellübersicht</h2>
                <div class="order-list">
                    <?php
                    foreach ($_SESSION['warenkorb_Produkt'] as $produkt_id => $menge) {
                        $sql = "SELECT ProduktID, Produktname, Preis FROM produkt WHERE ProduktID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $produkt_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $produkt = $result->fetch_assoc();

                        if ($produkt) {
                            echo "<div class='item'>
                                    <div class='item-details'>
                                    <p class='item-name'>{$produkt['Produktname']}</p>
                                    <p class='item-price'>{$produkt['Preis']} €</p>
                                    <p class='item-quantity'>Menge: {$menge}</p>
                                    <a href='warenkorb.php?action=add&id={$produkt['ProduktID']}&type=produkt'                                   class='add-item'><i class='fa-solid fa-plus'></i></a>
                                    <a href='warenkorb.php?action=remove&id={$produkt['ProduktID']}&type=produkt'                                   class='remove-item'><i class='fa-solid fa-trash'></i></a>
                                    </div>
                                    </div>";
                        }
                    }

                    foreach ($_SESSION['warenkorb_Menue'] as $menue_id => $menge) {
                        $sql = "SELECT MenueID, Menuename, DiscountPreis FROM menue WHERE MenueID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $menue_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $menue = $result->fetch_assoc();

                        if ($menue) {
                            echo "<div class='item'>
                                    <div class='item-details'>
                                        <p class='item-name'>{$menue['Menuename']}</p>
                                        <p class='item-price'>{$menue['DiscountPreis']} €</p>
                                        <p class='item-quantity'>Menge: {$menge}</p>
                                        <a href='warenkorb.php?action=add&id={$menue['MenueID']}&type=menue' class='add-item'>
                                            <i class='fa-solid    fa-plus'></i>
                                        </a>
                                        <a href='warenkorb.php?action=remove&id={$menue['MenueID']}&type=menue' class='remove-item'>
                                            <i class='fa-solid  fa-trash'></i>
                                        </a>
                                    </div>
                                </div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="total">
                <span class="total-label">GESAMT (inkl. MwSt):</span>
                <span class="total-price"><?php echo $_SESSION['gesamtpreis']; ?> €</span>
            </div>
            <div class="section">
                <h2>Lieferadresse</h2>
                <form method="POST" action="warenkorb.php">
                    <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($adresse['Nachname'] ?? ''); ?>" required>
                    <div class="address-container">
                        <input type="text" name="strasse" placeholder="Straße" value="<?php echo htmlspecialchars($adresse['Strasse'] ?? ''); ?>" required>
                        <input type="text" name="hausnummer" placeholder="Hausnummer" value="<?php echo htmlspecialchars($adresse['Hausnummer'] ?? ''); ?>" required>
                    </div>
                    <input type="text" name="plz" placeholder="PLZ" value="<?php echo htmlspecialchars($adresse['Postleitzahl'] ?? ''); ?>" required>
                    <input type="text" name="stadt" placeholder="Stadt" value="<?php echo htmlspecialchars($adresse['Stadt'] ?? ''); ?>" required>
                    <div class="section">
                        <h2>Zahlungsmethode</h2>
                        <select name="zahlungsart">
                            <?php foreach ($zahlungsarten as $zahlungsart): ?>
                                <option value="<?php echo htmlspecialchars($zahlungsart); ?>"><?php echo htmlspecialchars($zahlungsart); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <a href='warenkorb.php?action=clear'><button type="button">Warenkorb leeren</button></a>
                    <button type="submit" name="checkout" class="checkout-button">Bestellung abschließen</button>
                </form>
            </div>
        </div>
    </main>
    <?php include './partials/footer.php'; ?>
</body>

</html>


<style>
/* Fehlermeldung-Banner */
.error-banner {
    width: 100%;
    background-color: #FF5733; /* Roter Hintergrund für Fehler */
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
.error-banner a {
    color: #721c24; /* Gleiche Farbe wie der Text */
    text-decoration: underline; /* Unterstrichen, damit es wie ein Link aussieht */
}

.error-banner a:hover {
    color: #004085; /* Dunkleres Blau für den Hover-Effekt */
    text-decoration: none; /* Entfernt Unterstreichung beim Hover */
}

</style>
